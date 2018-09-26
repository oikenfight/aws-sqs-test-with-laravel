export default {
    pushToBackendQueues ({commit}, data) {
        switch (data.target) {
            case 'backendA':
                commit('PUSH_QUEUE_TO_A', data.queue)
                break
            case 'backendB':
                commit('PUSH_QUEUE_TO_B', data.queue)
                break
            case 'backendC':
                commit('PUSH_QUEUE_TO_C', data.queue)
                break
        }
    },
}

