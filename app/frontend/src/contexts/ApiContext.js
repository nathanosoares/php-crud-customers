import { createContext } from 'react';
import env from "react-dotenv";
import axios from 'axios';

const client = axios.create({
  baseURL: env.BACKEND_URL || 'http://127.0.0.1:8000/',
  delayed: true // Simula um delay na api
});

client.interceptors.request.use((config) => {
  if (config.delayed) {
    return new Promise(resolve => setTimeout(() => resolve(config), 300));
  }
  return config;
});

export const ApiContext = createContext();

export const ApiContextProvider = ({ children }) => {

  const setAuthorizationToken = token => {
    client.defaults.headers.common['Authorization'] = token ? `Bearer ${token}` : null;
  };

  const postCustomer = async (customer) => {
    try {
      const url = customer.id ? `customers/${customer.id}` : `customers`;

      const response = await client.post(url, customer);

      if (response.data.success) {
        return { success: true, ...response.data };
      }

      return { success: false, error: response.data.error };

    } catch (error) {
      
      if (error.response) {
        return { success: false, error: error.response.data.error };
      }

      return { success: false };

    }
  };

  const postAddress = async (customer, address) => {
    try {
      const url = address.id
        ? `customers/${customer.id}/addresses/${address.id}`
        : `customers/${customer.id}/addresses`;

      const response = await client.post(url, address);

      if (response.data.success) {
        return { success: true };
      }

      return { success: false, error: response.data.error };

    } catch (error) {

      return { success: false, error };

    }
  };

  const deleteCustomer = async (customer) => {
    try {
      const response = await client.delete(`customers/${customer.id}`, customer);

      if (response.data.success) {
        return { success: true };
      }

      return { success: false, error: response.data.error };

    } catch (error) {

      return { success: false, error };

    }
  };

  return (
    <ApiContext.Provider value={{
      setAuthorizationToken, client, postCustomer, postAddress, deleteCustomer
    }}>
      {children}
    </ApiContext.Provider>
  );
};