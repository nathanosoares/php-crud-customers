function FormInput({ className, label, ...props }) {
    return (<>
        <input
            className={`shadow-sm w-full p-2 text-primary border rounded-md outline-none text-sm transition duration-150 ease-in-out mb-4 ${className}`}
            {...props}
        />
    </>);
}

export default FormInput;
