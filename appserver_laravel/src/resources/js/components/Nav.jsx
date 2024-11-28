import React, { useState, useEffect } from 'react'
import { Link, useLocation } from 'react-router-dom'
import styles from './Nav.module.css'
import GoogleSignInButton from './GoogleSignInButton.jsx'
import { useUserContext } from '../contexts/UserContext'

const Nav = ({ routeClass }) => {

    const user = useUserContext()
    const [open, setOpen] = useState(false)
    const handleOpen = () => setOpen(!open)
    const [smallDevice, setSmallDevice] = useState(
    window.matchMedia('(max-width: 485px)').matches
    )

    useEffect(() => {
    window
      .matchMedia('(max-width: 485px)')
      .addEventListener('change', e => setSmallDevice( e.matches ))
    }, [])

    // cargar clase de css modules de nombre routeClass
    const moduleClass = styles[routeClass]

    if (smallDevice) {
        // DISPOSITIVOS PEQUEÑOS
        return (
          <nav className={`${styles.nav} ${moduleClass}`}>
            <button className='menu' onClick={handleOpen} />
            {open ? (
              <ul className={styles.navUl}>
                <li className={styles.item}><Link to={'/'} onClick={handleOpen}>Home</Link></li>
                <li className={styles.item}><Link to={'/blogs'} onClick={handleOpen}>Blogs</Link></li>
                <li className={styles.item}><Link to={'/memes'} onClick={handleOpen}>Memes</Link></li>
              </ul>
            ) : null}
          </nav>
        )
    } else {
        return (
          <nav className={`${styles.nav} ${moduleClass}`}>
            <ul className={styles.navUl}>
              <li className={styles.item}><Link to={'/'}>Home</Link></li>
              <li className={styles.item}><Link to={'/blogs'}>Blogs</Link></li>
              <li className={styles.item}><Link to={'/memes'}>Memes</Link></li>
              {user ? (<UserCard />) : (<li style={{"display": "inline-block", "marginLeft": "auto"}}><GoogleSignInButton /></li>)}
            </ul>
          </nav>
        )
    }
}

const UserCard = () => {
        const user = useUserContext()

        return (
            <li className={styles.userCard}>
                <Link to={'/profile'}>{user.firstname}</Link>
            </li>
        )
}

export default Nav
