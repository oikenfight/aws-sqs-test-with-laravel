<template>
    <div class="container">
        <div class="row">
            <div class="col-12" style="padding-top: 40px;">
                <div class="card card-default">
                    <div class="card-header">Send SQS (API Server)</div>

                    <div class="card-body">
                        <div class="form form-inline">
                            <!-- message -->
                            <div class="form-group col-12">
                                <label class="col-form-label col-2 text-right" for="formMessage">Message</label>
                                <input class="form-control col-9" v-model="form.message" id="formMessage">
                            </div>

                            <!-- submit -->
                            <div class="form-group col-12" style="padding-top: 20px;">
                                <button type="button" class="offset-2 btn btn-primary" :class="{disabled: isDisabled}" @click="send">EnQueue</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6" style="padding-top: 40px;">
                <div class="card card-default">
                    <div class="card-header">Process</div>

                    <div class="card-body">
                        Here is a area to display current Process.
                    </div>
                </div>
            </div>

            <div class="col-6" style="padding-top: 40px;">
                <div class="card card-default">
                    <div class="card-header">Got SQS (ADB Server)</div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="float-right">
                                    <button class="btn btn-success" :class="{disabled: running}" @click="startBatch">Start</button>
                                    <button class="btn btn-danger" :class="{disabled: !running}" @click="stopBatch">Stop</button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <p>queues</p>
                                <ul class="list-group">
                                    <li class="list-group-item" v-for="queue in queues">
                                        {{ queue.Body }}
                                        <span class="float-right btn btn-danger" @click="deleteQueue(queue)">Delete</span>
                                    </li>
                                </ul>
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
                form: {
                    message: ''
                },
                queues: [],
                queuesBodies: [],
                requestCount: 0,
                running: false,
            }
        },
        computed: {
            isDisabled () {
                return this.form.message === ''
            },
        },
        methods: {
            send () {
                axios.post('/api/sqs_test/send', this.form)
                    .then(response => {
                        console.log('send: ' + this.form.message + ', response: ')
                        console.log(response)
                        this.form.message = ''
                })
            },
            countUp () {
                this.requestCount++
            },
            startBatch () {
                this.running = true
                let batch = setInterval(() => {
                    this.countUp()
                    console.log(this.requestCount)
                    axios.get('api/sqs_test/get')
                    .then(response => {
                        console.log(response.data.messages)
                        response.data.messages.forEach((val, index) => {
                            if (this.queuesBodies.indexOf(val.Body) === -1) {
                                this.queues.push(val)
                                this.queuesBodies.push(val.Body)
                                console.log(this.queues)
                                console.log('pushed: ' + val)
                            }
                        })
                    })
                    if (!this.running) {
                        clearInterval(batch)
                    }
                }, 3000)
            },
            stopBatch () {
                this.running = false
                this.requestCount = 0
            },
            deleteQueue (queue) {
                axios.delete('api/sqs_test/delete', {data: queue})
                    .then(response => {
                        console.log(response)
                        this.queues.forEach((val, i) => {
                            if (queue === val) {
                                this.queues.splice(i, 1)
                                this.queuesBodies.splice(i, 1)
                            }
                        })
                })
            },
        },
    }
</script>
