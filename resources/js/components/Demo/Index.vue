<template>
    <div class="container">
        <front-app-component></front-app-component>
        <queue-manager-app-component></queue-manager-app-component>
    </div>
</template>

<script>
    import FrontAppComponent from './FrontAppComponent'
    import QueueManagerAppComponent from './QueueManagerAppComponent'

    export default {
        components: {
            'front-app-component': FrontAppComponent,
            'queue-manager-app-component': QueueManagerAppComponent,
        }
    }
</script>

<style scoped>

</style>
