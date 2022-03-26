import { useContext, useEffect } from "react";
import { Link } from "react-router-dom";
import LoadingSpinner from "../../../components/LoadingSpinner";
import PrimaryButton from "../../../components/PrimaryButton";
import { CustomersContext } from "../../../contexts/CustomersContext";
import CustomerViewElement from "./CustomersViewElement";

function CustomersViewList() {

  const { customers, loading, updateCustomersList } = useContext(CustomersContext);

  useEffect(() => {
    const update = async () => {
      await updateCustomersList();
    };

    update();
  }, []);

  return (<>
    <div>
      <p className="text-3xl font-light float-left">
        Clientes
      </p>

      <Link to={'/add'}>
        <PrimaryButton className="float-right">
          Cadastrar Cliente
        </PrimaryButton>
      </Link>

      <div className="clear-both"></div>
    </div>

    <div className="bg-slate-50 rounded-xl border border-gray-100 shadow-sm mt-12 relative">

      {loading && (
        <div className="text-center w-full h-full absolute bg-slate-50 z-50 flex items-center justify-center">
          <LoadingSpinner />
        </div>
      )}

      {customers.length == 0 && (<>
        <p className="text-center py-10 text-3xl text-gray-700">Nenhum cliente cadastrado.</p>
      </>)}

      {customers.length > 0 && (
        <table className="table-auto clear-both w-full ">

          <thead>
            <tr className="border-b">
              <th></th>
              <th className="text-left font-medium text-slate-500 pb-4 pt-4">Nome</th>
              <th className="text-left font-medium text-slate-500 pb-4 pt-4">Cidade</th>
              <th className="text-left font-medium text-slate-500 pb-4 pt-4">Documentos</th>
              <th></th>
            </tr>
          </thead>

          <tbody className="text-gray-900 bg-white">
            {customers.map(customer => (
              <CustomerViewElement customer={customer} key={customer.id} />
            ))}
          </tbody>

        </table>
      )}
    </div>
  </>);
}

export default CustomersViewList;