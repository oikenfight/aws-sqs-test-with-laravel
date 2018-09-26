export default {
    PUSH_QUEUE_TO_A (state, queue) {
        state.backendQueues.A.push(queue)
    },

    PUSH_QUEUE_TO_B (state, queue) {
        state.backendQueues.B.push(queue)
    },

    PUSH_QUEUE_TO_C (state, queue) {
        state.backendQueues.C.push(queue)
    },
}
