function PrimaryButton({ className, children, ...props }) {
    return (
        <button className={`bg-blue-600 py-2 px-4 text-white rounded focus:outline-none ${className}`}
            {...props}
        >
            {children}
        </button>
    );
}

export default PrimaryButton;
