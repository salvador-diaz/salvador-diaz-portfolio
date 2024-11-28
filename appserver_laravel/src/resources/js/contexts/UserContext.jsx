import { createContext, useEffect, useState, useContext } from 'react'
import authService from '../services/authService'

const UserContext = createContext(undefined)

export function UserContextProvider({children}) {
    const [user, setUser] = useState(undefined)

    // Se revisa autorización inicial
    useEffect(function() {
        async function checkAuth() {
            setUser(await authService.checkAuth())
        }
        checkAuth()
        
    }, [])

    return (
        <UserContext.Provider value={user}>
            {children}
        </UserContext.Provider>
    )

}

// Atajo para solo importar esta función para obtener el contexto, en vez de useContext + UserContext
export const useUserContext = () => useContext(UserContext)

export default UserContext
