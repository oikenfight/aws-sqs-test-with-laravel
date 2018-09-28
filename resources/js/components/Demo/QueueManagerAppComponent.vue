<template>
    <div class="row">
        <div class="col-12" style="padding-top: 40px;">
            <div class="card card-default">
                <div class="card-header">
                    Backend Queue Manage Server (get queues from SQS constantly)
                </div>

                <!-- body -->
                <div class="card-body">
                    <!-- start/stop -->
                    <div class="row" style="padding-bottom: 20px">
                        <div class="col-12">
                            <div class="float-right">
                                <button class="btn btn-success" :class="{disabled: running}" @click="startBatch">Start</button>
                                <button class="btn btn-danger" :class="{disabled: !running}" @click="stopBatch">Stop</button>
                            </div>
                        </div>
                    </div>
                    <!-- content -->
                    <div class="row">
                        <!-- All Queues in Redis -->
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    All Queues QueueManager has.
                                </div>
                                <div class="card-body">
                                    <ul class="list-group">
                                        <li class="list-group-item" v-for="queue in allQueues">
                                            <div class="float-right">
                                                <!-- TODO: add expired_at -->
                                                expired: <span class="badge badge-light">{{ queue.expired_time }}</span>
                                            </div>
                                            <div class="float-left">
                                                <p class="card-text">
                                                    device: {{ queue.device }} <br/>
                                                    body: {{ queue.body }}
                                                </p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                allQueues: [],
                running: false,
            }
        },
        methods: {
            startBatch () {
                this.running = true
                // Queue Manager の継続的な処理をスタート
                let batch = setInterval(() => {

                    // aws sqs から queue を取得し、QueueManagerService で可動してる Redis に保存してる
                    axios.get('api/demo/queue_manager/get')
                    .then(response => {
                        // parse response to json
                        console.log('queue manager get from aws sqs.')
                        console.log(response.data)
                    });

                    // Web 上に可視化するために Redis からデータを取得してる。
                    axios.get('api/demo/redis/queues')
                    .then(response => {
                        // parse response to json
                        console.log('queue manager get all queues from redis database.')
                        console.log(response.data.queues)
                        this.allQueues = response.data.queues
                    });

                    // ストップボタンが押されたら Interval 停止
                    if (!this.running) {
                        clearInterval(batch)
                    }
                }, 3000)
            },
            stopBatch () {
                // Queue Manager の継続的な処理を停止させる
                this.running = false
            },
        },
    }
</script>

<style scoped>

</style>
