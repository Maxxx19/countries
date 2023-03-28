import axios from 'axios'
import router from '../router'
export default {
    namespaced: true,
    state:{
        authenticated:false,
        user:{},
        continent: undefined,
    },
    getters:{
        authenticated(state){
            return state.authenticated
        },
        user(state){
            return state.user
        }, 
        continent(state){
            return state.continent
        }, 
    },
    mutations:{
        SET_AUTHENTICATED (state, value) {
            state.authenticated = value
        },
        SET_CONTINENT (state, value) {
            console.log(value)
            state.continent = value
        },
        SET_USER (state, value) {
            state.user = value
        }
    },
    actions:{
        login({commit}){
            console.log('login')
            return axios.get('/user').then(({data})=>{
                commit('SET_USER',data)
                console.log(data)
                commit('SET_AUTHENTICATED',true)
                
            }).catch(({response:{data}})=>{
                commit('SET_USER',{})
                commit('SET_AUTHENTICATED',false)
            })
        },
        logout({commit}){
            commit('SET_USER','{vvkv}')
            commit('SET_AUTHENTICATED',false)
        },
        current_continent({commit}, payload){
            console.log('current_continent')
            console.log(payload)
            commit('SET_CONTINENT', payload)
        },
    }
}
