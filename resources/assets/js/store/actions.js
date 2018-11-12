import axios from 'axios'

export const getProfile = ({commit}) => {
    axios
        .get('/user')
        .then(res => commit('setUser', res.data))
        .catch(() => commit('setUser'))
}

export const logOut = ({commit}) => {
    commit('setLoggedIn', false)
    commit('setUser')
    axios
        .delete('/logout')
        .then()
        .catch()
}
