import axios from "axios";
import { useContext, useEffect, useState } from "react";
import FormInput from "../../../../../components/FormInput";
import { CustomerFormContext } from "../../../../../contexts/CustomerFormContext";

const viaCepClient = axios.create({ baseURL: 'https://viacep.com.br/ws/' })

function AddressForm({ address: data = {} }) {

  const { address, setAddress } = useContext(CustomerFormContext);
  const [disabled, setDisabled] = useState({});

  useEffect(() => {
    setAddress(data);

    return () => {
      setAddress({});
    };
  }, []);

  const handleChanges = (event) => {
    const name = event.target.name;
    const value = event.target.value;
    
    setAddress(values => ({ ...values, [name]: value }));

    if (name == 'cep') {
      handleCepChange(value);
    }
  }

  const handleCepChange = async (cep) => {

    cep = cep.replace(/[^\d]/g, "");

    if (cep && cep.length == 8) {
      const response = await viaCepClient.get(`${cep}/json`);

      if (response.data?.cep) {
        setAddress(values => ({
          ...values,
          ...{
            street: response.data.logradouro,
            city: response.data.localidade,
            uf: response.data.uf,
            district: response.data.bairro,
          }
        }));

        setDisabled({
          street: !!response.data.logradouro,
          city: !!response.data.localidade,
          uf: !!response.data.uf,
          district: !!response.data.bairro,
        });
      } else {
        setDisabled({
          street: false,
          city: false,
          uf: false,
          district: false
        });
      }
    }
  }

  return (<>
    <form className="bg-gray-50 py-4 rounded my-4">

      <div className="px-4">
        <label>CEP:</label>
        <FormInput mask="99999-999" type="text" name="cep" id="cep" value={address.cep || ""} onChange={handleChanges} disabled={disabled.cep} />
      </div>

      <div className="w-4/6 inline-block px-4">
        <label>Rua:</label>
        <FormInput type="text" name="street" id="street" value={address.street || ""} onChange={handleChanges} disabled={disabled.street} />
      </div>

      <div className="w-2/6 inline-block px-4">
        <label>Número:</label>
        <FormInput type="text" name="number" id="number" value={address.number || ""} onChange={handleChanges} disabled={disabled.number} />
      </div>

      <div className="px-4">
        <label>Bairro:</label>
        <FormInput type="text" name="district" id="district" value={address.district || ""} onChange={handleChanges} disabled={disabled.district} />
      </div>

      <div className="w-1/2 inline-block px-4">
        <label>Cidade:</label>
        <FormInput type="text" name="city" id="city" value={address.city || ""} onChange={handleChanges} disabled={disabled.city} />
      </div>

      <div className="w-1/2 inline-block px-4">
        <label>Estado:</label>
        <FormInput type="text" name="uf" id="uf" value={address.uf || ""} onChange={handleChanges} disabled={disabled.uf} />
      </div>
    </form>
  </>);
}

export default AddressForm;