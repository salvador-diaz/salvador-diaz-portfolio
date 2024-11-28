import styles from './GoogleSignInButton.module.css'

function GoogleSignInButton() {
    let redirectUri = import.meta.env.VITE_GOOGLE_OAUTH_REDIRECT_URI;
    let clientId = import.meta.env.VITE_GOOGLE_OAUTH_CLIENTID
    return (
        <a className={styles.googleSignInButton} href={"https://accounts.google.com/o/oauth2/auth?client_id="+clientId+"&redirect_uri="+redirectUri+"&response_type=code&scope=email%20profile"}>
            Sign in with Google
        </a>
    )
}

export default GoogleSignInButton

