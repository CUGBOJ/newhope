export const setLoggedIn = (state, status) => {
    state.loggedIn = status
}

export const setUser = (state, data) => {
    state.user = data
    if (!data) {
        state.loggedIn = false
    } else {
        state.loggedIn = true
    }
}
