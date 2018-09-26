<template>
    <div class="container">
        <front-app-component></front-app-component>
        <queue-manager-app-component></queue-manager-app-component>
        <backend-app-component></backend-app-component>
    </div>
</template>

<script>
    import FrontAppComponent from './FrontAppComponent'
    import QueueManagerAppComponent from './QueueManagerAppComponent'
    import BackendAppComponent from './BackendAppComponent'

    export default {
        components: {
            'front-app-component': FrontAppComponent,
            'queue-manager-app-component': QueueManagerAppComponent,
            'backend-app-component': BackendAppComponent,
        }
    }
</script>

<style scoped>

</style>
