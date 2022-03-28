import InputMask from 'react-input-mask';

function FormInput({ className, label, ...props }) {
    return (<>
        <InputMask
            className={`shadow-sm w-full p-2 text-primary border rounded-md outline-none text-sm transition duration-150 ease-in-out mb-4 ${className}`}
            {...props}
        ></InputMask>
    </>);
}

export default FormInput;
