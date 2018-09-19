<template>
    <div class="container">
        <front-app-component></front-app-component>
    </div>
</template>

<script>
    import FrontAppComponent from './FrontAppComponent'

    export default {
        components: {
            'front-app-component': FrontAppComponent,
        }
    }
</script>

<style scoped>

</style>
