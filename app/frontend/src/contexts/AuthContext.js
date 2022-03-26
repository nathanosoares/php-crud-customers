import { createContext, useContext, useEffect, useState } from 'react';
import { ApiContext } from './ApiContext';

export const AuthContext = createContext();

export const AuthContextProvider = ({ children }) => {

  const { client, setAuthorizationToken } = useContext(ApiContext);

  const [token, setToken] = useState(localStorage.getItem('auth_token'));

  async function login({ username, password }) {

    try {
      const response = await client.post('auth/login', {
        username,
        password
      });

      if (response.data.success && response.data.token) {
        setSessionToken(response.data.token);

        return { success: true };
      }

      return { success: false, error: response.data.error };

    } catch (error) {

      return { success: false, error };
    }
  }

  async function logout() {
    setSessionToken(null);
  }

  async function refreshAuth() {
    try {
      const authToken = localStorage.getItem('auth_token');

      if (authToken) {
        const response = await client.get('auth/refresh', {
          headers: {
            Authorization: `Bearer ${authToken}`
          }
        });

        if (response.data.success && response.data.token) {
          setSessionToken(response.data.token);
          return;
        }
      }

      logout();

    } catch (error) {

      logout();
    }
  }

  function setSessionToken(token) {

    if (token) {
      localStorage.setItem('auth_token', token);
    } else {
      localStorage.removeItem('auth_token');
    }

    setAuthorizationToken(token);
    setToken(token);
  }

  setAuthorizationToken(token);

  useEffect(() => {
    const refresh = async () => {
      await refreshAuth();
    };

    refresh();
  }, []);

  return (
    <AuthContext.Provider value={{
      login, logout, refreshAuth, token
    }}>
      {children}
    </AuthContext.Provider>
  );
}

export default AuthContextProvider;