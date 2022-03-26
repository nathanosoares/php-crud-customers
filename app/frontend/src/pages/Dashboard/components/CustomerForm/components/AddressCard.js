import { useEffect, useRef, useState } from "react";

function AddressCard({ address }) {

  const [displayAction, setDisplayAction] = useState(false);
  const actionDropdownRootRef = useRef(null);

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

  return (
    <div className="relative w-1/2 inline-block px-4 mt-4">
      <div className="border-2 border-dashed rounded p-4 flex">
        <div className="">
          <p className="text-gray-900">{address.street}, {address.number} - {address.district}</p>
          <p className="text-gray-900 font-light">{address.city}, {address.uf} - CEP {address.cep}</p>
        </div>

        <div className="text-right flex-1" ref={actionDropdownRootRef}>
          <button className="py-2 px-4 text-gray-600 rounded-full focus:outline-none"
            onClick={() => setDisplayAction(!displayAction)}>
            ...
          </button>

          <div className={`${displayAction ? 'absolute' : 'hidden'} text-left top-15 z-12 w-40 bg-white rounded divide-gray-100 shadow dark:bg-gray-700 right-10`}>

            <ul className="py-1 text-sm text-gray-700 dark:text-gray-200">
              <li>
                <span
                  onClick={e => {
                    setDisplayAction(false);
                  }}
                  className="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                  Excluir
                </span>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  );
}

export default AddressCard;