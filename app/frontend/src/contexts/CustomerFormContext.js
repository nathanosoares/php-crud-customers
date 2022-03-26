import { createContext, useContext, useState } from 'react';
import { ApiContext } from './ApiContext';

export const CustomerFormContext = createContext();

export const CustomerFormContextContextProvider = ({ children }) => {

  const { postCustomer, postAddress } = useContext(ApiContext);

  const [customer, setCustomer] = useState({});
  const [address, setAddress] = useState({});

  const setInput = (field, value) => {
    setCustomer(fields => ({ ...fields, [field]: value }));
  };

  const submitCustomer = async () => {
    try {
      const response = await postCustomer(customer, address);

      if (response.success) {

        if (response.customer_id) {
          customer.id = response.customer_id

          setCustomer(customer);
        }

        return response;
      }

      return response;

    } catch (error) {

      return { success: false, error };

    }
  }

  const submitAddress = async () => {
    try {

      if (!address || Object.keys(address).length === 0) {
        return { success: true };
      }

      const response = await postAddress(customer, address);

      if (response.success) {
        return response;
      }

      return response;

    } catch (error) {

      return { success: false, error };

    }
  };

  return (
    <CustomerFormContext.Provider value={{
      setCustomer, setInput, customer, submitCustomer, address, setAddress, submitAddress
    }}>
      {children}
    </CustomerFormContext.Provider>
  );
};

export default CustomerFormContextContextProvider;