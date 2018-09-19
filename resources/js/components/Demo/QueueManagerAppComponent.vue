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
                        <!-- Response Queues -->
                        <div class="col-6">
                            <div class="card">
                                <div class="card-header">
                                    Queues got from sqs
                                </div>
                                <div class="card-body">
                                    <ul class="list-group">
                                        <li class="list-group-item" v-for="queue in responseQueues">
                                            <div class="float-left">
                                                <p class="card-text">
                                                    device: {{ queue.Body.Message.device }} <br/>
                                                    body: {{ queue.Body.Message.body }}
                                                </p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <!-- Controlling Queues -->
                        <div class="col-6">
                            <div class="card">
                                <div class="card-header">
                                    Queues Backends are controlling
                                </div>
                                <div class="card-body">
                                    <ul class="list-group">
                                        <li class="list-group-item" v-for="queue in controllingQueues">
                                            <div class="float-right">
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
                responseQueues: [],
                controllingQueues: [],
                running: false,
            }
        },
        mounted () {
            setInterval(() => {
                // 期限切れ Queue を削除
                Object.keys(this.controllingQueues).forEach((val, index) => {
                    if (this.controllingQueues[index].expired_time > 0) {
                        this.controllingQueues[index].expired_time -= 1
                    } else {
                        this.controllingQueues.splice(index, 1)
                    }
                })
            }, 1000)
        },
        methods: {
            startBatch () {
                this.running = true
                let batch = setInterval(() => {
                    axios.get('api/demo/queue_manager/get')
                    .then(response => {
                        // parse response to json
                        this.responseQueues = response.data.queues.map((val) => {
                            val.Body = JSON.parse(val.Body)
                            val.Body.Message = JSON.parse(val.Body.Message)
                            return val
                        })

                        // 受け取ったデータを追加
                        this.responseQueues.forEach((val, index) => {
                            let targetDevice = val.Body.Message.device
                            let key = this.controllingQueues.findIndex((queue) => queue.device === targetDevice)
                            if (key === -1) {
                                this.controllingQueues.push({
                                    'device': targetDevice,
                                    'body': val.Body.Message.body,
                                    'receipt_handle': val.ReceiptHandle,
                                    'expired_time': 25,    // 処理中を想定して、データを保持する時間
                                })
                            }
                        })
                    })

                    // ストップボタンが押されたら Interval 停止
                    if (!this.running) {
                        clearInterval(batch)
                    }
                }, 3000)
            },
            stopBatch () {
                this.running = false
            },
        },
    }
</script>

<style scoped>

</style>
