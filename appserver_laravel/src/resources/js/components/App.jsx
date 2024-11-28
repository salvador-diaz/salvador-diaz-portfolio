import './App.css'
import { Routes, Route, useLocation } from 'react-router-dom'
import Nav from './Nav.jsx'
import IndexCanvas from './IndexCanvas.jsx'
import DefaultLayout from '../layouts/DefaultLayout.jsx'
import PageNotFound from './PageNotFound.jsx'
import Blogs from '../views/Blogs.jsx'
import { UserContextProvider } from '../contexts/UserContext.jsx'
 
function App() {

    // Información de la ruta actual
    const location = useLocation()
    // Css específico para Nav en index
    const routeClass = location.pathname === "/" ? "navIndex" : "navDefault"

    return (
        <UserContextProvider>
            <Nav
                routeClass={location.pathname === "/" ? "navIndex" : "navDefault"}
            />
            <Routes>
                <Route path="/" element={<IndexCanvas />} />
                <Route path="/" element={<DefaultLayout />}>
                    <Route path="/blogs" element={<Blogs />} />
                    <Route  path="*" element={<PageNotFound />}/>
                </Route>
            </Routes>
        </UserContextProvider>
    )
}

export default App
