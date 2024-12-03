// src/store.js
import {createStore} from 'vuex';

const store = createStore({
    state: {
        count: Number(localStorage.getItem('count')) || 0,
    },
    mutations: {
        increment(state) {
            state.count++;
            localStorage.setItem('count', state.count);
        },
        decrement(state) {
            state.count--;
            localStorage.setItem('count', state.count);
        },
    },
    actions: {
        increment({ commit }) {
            commit('increment');
        },
        decrement({ commit }) {
            commit('decrement');
        },
    },
    getters: {
        getCount(state) {
            return state.count;
        },
    },
});

export default store;
