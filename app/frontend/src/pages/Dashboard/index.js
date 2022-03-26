import { useContext } from "react";
import { Navigate, Route, Routes } from "react-router-dom";
import { AuthContext } from "../../contexts/AuthContext";
import CustomerForm from "./components/CustomerForm";
import CustomersViewList from "./components/CustomersViewList";
function DashboardPage() {

  const { logout } = useContext(AuthContext);

  function handleLogout() {
    logout();
  }

  return (<>
    <div className='h-screen flex'>
      <div className='w-full max-w-6xl mx-auto'>
        <div className='py-3 text-right'>
          <button className='text-blue-800 underline cursor-pointer' onClick={handleLogout}>
            Sair
          </button>
        </div>

        <div className='bg-white p-12 rounded shadow-md mt-4'>
          <div>
            <Routes>
              <Route path="/" element={<CustomersViewList />} />
              <Route path="/add" element={<CustomerForm />} />
              <Route path="/edit" element={<CustomerForm />} />
              <Route path="*" element={<Navigate to={'/'} />} />
            </Routes>
          </div>
        </div>
      </div>
    </div>
  </>);
}

export default DashboardPage;