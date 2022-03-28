import { useContext, useEffect, useState } from "react";
import { Link, useLocation, useNavigate } from "react-router-dom";
import FormInput from "../../../../components/FormInput";
import PrimaryButton from "../../../../components/PrimaryButton";
import { CustomerFormContext } from "../../../../contexts/CustomerFormContext";
import { CustomersContext } from "../../../../contexts/CustomersContext";
import AddressCard from "./components/AddressCard";
import AddressForm from "./components/AddressForm";

function CustomerForm() {

  const location = useLocation();
  const { data = {} } = location.state || {};

  const navigate = useNavigate();

  const [showAddressForm, setShowAddressForm] = useState(false);
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState(null);

  const { updateCustomersList } = useContext(CustomersContext);
  const { setInput, customer, setCustomer, submitCustomer, submitAddress } = useContext(CustomerFormContext);

  useEffect(() => {
    setCustomer(data);

    return () => {
      setCustomer({});
    };
  }, []);

  const handleChanges = event => {
    setInput(event.target.name, event.target.value);
  }

  const handleSubmit = async (event) => {
    setLoading(true);
    setError(null);

    event.preventDefault();

    let result = await submitCustomer();

    if (result.success) {
      await submitAddress();

      updateCustomersList();
      navigate("/");
    } else {
      setError(result.error);
    }

    setLoading(false);
  }

  return (<>
    <p className="text-2xl mb-4">Dados</p>

    {error && (<>
      <div className="bg-red-200 rounded p-4 my-4 text-red-800">
        {error}
      </div>
    </>)}

    <form onSubmit={handleSubmit}>
      <label>Nome:</label>
      <FormInput
        type="text"
        name="name"
        id="name"
        value={customer.name || ""}
        onChange={handleChanges}
      />

      <label>Nascimento:</label>
      <FormInput
        type="text"
        name="birth_date"
        mask="99/99/9999"
        value={customer.birth_date || ""}
        onChange={handleChanges}
      />

      <label>CPF:</label>
      <FormInput
        type="text"
        name="document_cpf"
        mask="999.999.999-99"
        value={customer.document_cpf || ""}
        onChange={handleChanges}
      />

      <label>RG:</label>
      <FormInput
        type="text"
        name="document_rg"
        value={customer.document_rg || ""}
        onChange={handleChanges}
      />

      <label>Telefone:</label>
      <FormInput
        type="text"
        name="phone"
        mask="(99) 99999-9999"
        value={customer.phone || ""}
        onChange={handleChanges}
      />
    </form>

    <hr className="my-4" />

    <p className="text-2xl">Endereços</p>

    {customer.addresses && (<div>
      {customer.addresses.map(address => (<AddressCard address={address} key={address.id} />))}
    </div>)}

    {(!showAddressForm || (!customer.addresses || customer.addresses.length == 0)) && (
      <PrimaryButton className="py-1 px-2 mt-6" onClick={event => setShowAddressForm(true)}>
        Adicionar endereço
      </PrimaryButton>
    )}

    {showAddressForm && <AddressForm />}

    <div className="text-right mt-4">
      <Link to={'/'} className="py-2 px-4 text-red-500 border border-red-300 rounded mr-4">
        Cancelar
      </Link>

      <PrimaryButton onClick={handleSubmit}>
        {loading && (<svg className="animate-spin h-5 w-5 mr-2 inline align-top" viewBox="0 0 24 24">
          <circle className="opacity-10" cx="12" cy="12" r="10" stroke="currentColor" strokeWidth={4}></circle>
          <path className="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>)} Salvar
      </PrimaryButton>
    </div>
  </>);
}

export default CustomerForm;