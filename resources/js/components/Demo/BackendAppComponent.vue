<template>
    <div class="row">
        <div class="col-12" style="padding-top: 40px;">
            <div class="card card-default">
                <div class="card-header">
                    Backend App (Display Queues of Each Backend App)
                </div>

                <!-- body -->
                <div class="card-body">
                    <!-- content -->
                    <div class="row">
                        <!-- Each Backend App -->
                        <div v-for="(queues, target) in backendQueues" class="col-4">
                            <div class="card">
                                <div class="card-header">
                                    Queues of {{ target }}
                                </div>
                                <div class="card-body">
                                    <!-- start/stop -->
                                    <div class="row" style="padding-bottom: 20px">
                                        <div class="col-12">
                                            <div class="float-right">
                                                <button class="btn btn-success" :class="{disabled: statuses[target]}" @click="startBatch(target)">Start</button>
                                                <button class="btn btn-danger" :class="{disabled: !statuses[target]}" @click="stopBatch(target)">Stop</button>
                                            </div>
                                        </div>
                                    </div>

                                    <ul class="list-group">
                                        <li class="list-group-item" :class="{disabled: queue.expired_time <= 0}" v-for="queue in queues">
                                            <!--<div class="row">-->
                                            <!--<div class="float-right">-->
                                            <!--</div>-->
                                            <!--</div>-->
                                            <div class="float-left">
                                                <p class="card-text">
                                                    device: {{ queue.device }} <br/>
                                                    body: {{ queue.body }}
                                                </p>
                                            </div>
                                            <button type="button" class="btn btn-sm btn-danger float-right" @click="destroy(queue)">Delete</button>
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
    // import { mapGetters } from 'vuex'

    export default {
        name: 'BackendAppAComponent',
        data () {
            return {
                names: {
                    A: 'BackendAppA',
                    B: 'BackendAppB',
                    C: 'BackendAppC',
                },
                statuses: {
                    A: false,
                    B: false,
                    C: false,
                },
                backendQueues: {
                    A: [],
                    B: [],
                    C: [],
                },
                batches: {
                    A: null,
                    B: null,
                    C: null,
                }
            }
        },
        methods: {
            startBatch (target) {
                let name = this.names[target]
                this.statuses[target] = true

                // Queue Manager の継続的な処理をスタート
                this.batches[target] = setInterval(() => {
                    // Web 上に可視化するために Redis からデータを取得してる。
                    axios.get('api/demo/redis/queues/' + name)
                    .then(response => {
                        // parse response to json
                        console.log(name + ' gets itself queues from redis database.')
                        console.log(response.data.queues)
                        this.backendQueues[target] = response.data.queues
                    });

                    // ストップボタンが押されたら Interval 停止
                    if (!this.statuses[target]) {
                        clearInterval(this.batches[target])
                        this.batches[target] = null
                    }
                }, 3000)
            },
            stopBatch (target) {
                // Queue Manager の継続的な処理を停止させる
                this.statuses[target] = false
            },
            destroy (queue) {
                axios.delete('api/demo/queue_manager/destroy', {data: {queue: queue}})
                .then(response => {
                    // parse response to json
                    console.log(queue.device + ' is deleted')
                    console.log(response.data)
                });
            },
        },
    }
</script>

<style scoped>

</style>
