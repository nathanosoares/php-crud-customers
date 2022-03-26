import { useContext } from 'react';
import { BrowserRouter, Routes, Route, Navigate } from 'react-router-dom';

import { AuthContext } from './contexts/AuthContext';
import CustomerFormContextContextProvider from './contexts/CustomerFormContext';
import CustomersContextProvider from './contexts/CustomersContext';

import DashboardPage from './pages/Dashboard';
import LoginPage from './pages/Login';

function App() {

  const { token } = useContext(AuthContext);

  return (
    <CustomersContextProvider>
      <CustomerFormContextContextProvider>
        <BrowserRouter>
          <Routes>

            {!token && <Route path="/login" element={<LoginPage />} />}
            {token && <Route path="/*" element={<DashboardPage />} />}

            <Route path="*" element={<Navigate to={token ? '/' : '/login'} />} />

          </Routes>
        </BrowserRouter>
      </CustomerFormContextContextProvider>
    </CustomersContextProvider>
  );
}

export default App;
