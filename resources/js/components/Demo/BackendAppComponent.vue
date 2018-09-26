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
                        <div v-for="(queues, section) in backendQueues" class="col-4">
                            <div class="card">
                                <div class="card-header">
                                    Queues of {{ section }}
                                </div>
                                <div class="card-body">
                                    <ul class="list-group">
                                        <li class="list-group-item" :class="{disabled: queue.expired_time <= 0}" v-for="queue in queues">
                                            <div v-if="queue.expired_time <= 0" class="row">
                                                <span class="float-right badge badge-danger">requested destroy</span>
                                            </div>
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
    import { mapGetters } from 'vuex'

    export default {
        name: 'BackendAppAComponent',
        data () {
            return {}
        },
        computed: {
            ...mapGetters({
                backendQueues: 'backendQueues',
            }),
        },
        mounted () {
            setInterval(() => {
                // 期限切れ Queue を削除
                Object.keys(this.backendQueues).forEach((target) => {
                    if (this.backendQueues[target].length > 0) {
                        this.backendQueues[target].forEach((queue) => {
                            if (queue.expired_time === 0) {
                                // request to destroy this queue
                                axios.delete('api/demo/queue_manager/destroy', {data: {queue: queue}}).then((response) => {
                                    console.log(queue.device + 'was requested to delete')
                                })
                            } else if (queue.expired_time < 0) {
                                console.log(queue.device + 'has been requested to delete')
                            }
                        })
                    }
                })
            }, 1000)
        },
    }
</script>

<style scoped>

</style>
