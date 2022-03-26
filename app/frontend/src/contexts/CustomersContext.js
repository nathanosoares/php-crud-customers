import { createContext, useContext, useState } from 'react';
import { ApiContext } from './ApiContext';

export const CustomersContext = createContext();

export const CustomersContextProvider = ({ children }) => {

  const { client, deleteCustomer } = useContext(ApiContext);

  const [loading, setLoading] = useState(false);
  const [customers, setCustomers] = useState([]);

  const updateCustomersList = async () => {
    try {
      setLoading(true);

      const response = await client.get('customers');

      if (response.data) {
        setCustomers(response.data);
      }

    } finally {
      setLoading(false);
    }
  };

  const handleDelete = async customer => {
    setLoading(true);
    const response = await deleteCustomer(customer);

    if (response.success) {
      await updateCustomersList();
    }

    setLoading(false);
  }

  return (
    <CustomersContext.Provider value={{
      updateCustomersList, customers, loading, handleDelete
    }}>
      {children}
    </CustomersContext.Provider>
  );
}

export default CustomersContextProvider;