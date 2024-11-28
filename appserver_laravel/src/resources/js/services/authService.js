const API_URL = '/api/auth';

async function checkAuth() {
  const response = await fetch(API_URL+'/check-auth', {credentials: 'include'});
  if (response.ok) {
      const data = await response.json()
      return data.payload
  } else {
    return null
  }
};

export default { checkAuth }
