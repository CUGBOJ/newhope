export const user = state => {
    if (state.loggedIn) return state.user
    else return null
}

export const loggedIn = state => state.loggedIn
