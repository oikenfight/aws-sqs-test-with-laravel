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
                                    Queues Backend Apps are controlling
                                </div>
                                <div class="card-body">
                                    <ul class="list-group">
                                        <li class="list-group-item" v-for="queue in controlledQueues">
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
                controlledQueues: [],
                running: false,
                devices: {
                    backendA: [
                        '08000000000',
                        '08000000001',
                        '08000000002',
                        '08000000003',
                    ],
                    backendB: [
                        '08000000004',
                        '08000000005',
                        '08000000006',
                    ],
                    backendC: [
                        '08000000007',
                        '08000000008',
                        '08000000009',
                    ],
                }
            }
        },
        mounted () {
            setInterval(() => {
                // 期限切れ Queue を削除
                Object.keys(this.controlledQueues).forEach((val, index) => {
                    if (this.controlledQueues[index].expired_time >= 0) {
                        // オリジナルのこれが更新されれば、index.state.backendQueues の queue も更新される。
                        this.controlledQueues[index].expired_time -= 1
                    } else {
                        this.controlledQueues.splice(index, 1)
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

                        console.log(this.responseQueues)

                        // 受け取ったデータを追加
                        this.responseQueues.forEach((val, index) => {
                            let targetDevice = val.Body.Message.device
                            let key = this.controlledQueues.findIndex((queue) => queue.device === targetDevice)
                            if (key === -1) {
                                let queue = {
                                    'device': targetDevice,
                                    'body': val.Body.Message.body,
                                    'ReceiptHandle': val.ReceiptHandle,
                                    'expired_time': 25,    // 処理中を想定して、データを保持する時間
                                }

                                // 受け取った Queue が処理中でなかった場合
                                this.controlledQueues.push(queue)

                                // targetDevice（電話番号）から、適切な BackendApp にリクエスト
                                let targetBackendApp = ''
                                if (this.devices.backendA.indexOf(queue.device) > -1) {
                                    targetBackendApp = 'backendA'
                                } else if (this.devices.backendB.indexOf(queue.device) > -1) {
                                    targetBackendApp = 'backendB'
                                } else if (this.devices.backendC.indexOf(queue.device) > -1) {
                                    targetBackendApp = 'backendC'
                                }
                                console.log(queue)
                                console.log(queue.device)
                                console.log('targetApp: ' + targetBackendApp)
                                this.sendToBackendApp(targetBackendApp, queue)
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
            sendToBackendApp (target, queue) {
                axios.post('/api/demo/' + target, queue).then(response => {
                    console.log('send to: ' + target + ', device: ' + queue.device + ', response: ')
                    console.log(response)
                    this.$store.dispatch('pushToBackendQueues', {target: target, queue: queue})
                })
                // 本来なら vue でやり取りする必要は無いけど、可視化するため。
            },
        },
    }
</script>

<style scoped>

</style>
