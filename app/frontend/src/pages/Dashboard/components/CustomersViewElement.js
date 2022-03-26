import { useContext, useEffect, useRef, useState } from "react";
import { Link } from "react-router-dom";
import { CustomersContext } from "../../../contexts/CustomersContext";

function CustomersViewElement({ customer }) {

  const [displayAction, setDisplayAction] = useState(false);
  const actionDropdownRootRef = useRef(null);

  const { handleDelete } = useContext(CustomersContext);

  const handleDocumentClick = event => {
    if (actionDropdownRootRef.current && !actionDropdownRootRef.current.contains(event.target)) {
      setDisplayAction(false);
    }
  };

  useEffect(() => {
    document.addEventListener('click', handleDocumentClick, true);

    return () => {
      document.removeEventListener('click', handleDocumentClick, true);
    };
  }, []);

  return (<>
    <tr className="border-b">

      <td className="py-3" style={{ padding: 0, textAlign: 'center', width: 80 }}>
        <img
          className="rounded-full"
          style={{ display: 'inline-block' }}
          width={40}
          height={40}
          src={`https://api.lorem.space/image/pizza?w=150&h=150&${customer.id}`}
        />
      </td>

      <td className="py-3" width="25%">
        <p>{customer.name}</p>
        <p className="text-gray-600">
          {customer.phone}
        </p>
      </td>

      <td className="py-3" width="25%">
        {(customer.addresses?.length > 0 && (<p>{customer.addresses[0].city} - {customer.addresses[0].uf}</p>)
          || <p>Sem endereço</p>)}
      </td>

      <td className="py-3" width="20%">
        <p>{customer.document_cpf}</p>
        <p>{customer.document_rg}</p>
      </td>

      <td className="py-3 relative" ref={actionDropdownRootRef}>

        <div className="float-right">
          <button className="py-2 px-4 text-gray-600 rounded-full focus:outline-none"
            onClick={() => setDisplayAction(!displayAction)}>
            ...
          </button>
        </div>

        <div className={`${displayAction ? 'absolute' : 'hidden'} z-10 w-40 top-12 bg-white rounded divide-gray-100 shadow dark:bg-gray-700 right-3`}>

          <ul className="py-1 text-sm text-gray-700 dark:text-gray-200">
            <li>
              <Link to={'/edit'} state={{ data: customer }}
                className="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                Editar
              </Link>
            </li>

            <li>
              <span
                onClick={e => {
                  setDisplayAction(false);
                  handleDelete(customer);
                }}
                className="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                Excluir
              </span>
            </li>
          </ul>
        </div>

      </td>
    </tr>
  </>);
}

export default CustomersViewElement;