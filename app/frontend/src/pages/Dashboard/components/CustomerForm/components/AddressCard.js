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
      </div>
    </div>
  );
}

export default AddressCard;