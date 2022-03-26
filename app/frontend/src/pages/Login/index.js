import { useContext, useState } from 'react';

import FormInput from '../../components/FormInput';
import PrimaryButton from '../../components/PrimaryButton';
import { AuthContext } from '../../contexts/AuthContext'

function LoginPage() {

  const { login } = useContext(AuthContext);

  const [error, setError] = useState(null);

  const handleFormSubmit = async (event) => {
    event.preventDefault();

    setError(null);

    const username = event.target.elements.username?.value;
    const password = event.target.elements.password?.value;

    const result = await login({ username, password });

    if (!result.success) {
      setError(result.error);
    }
  };

  return (
    <div className='h-screen flex bg-gray-100'>
      <div className='w-full max-w-md m-auto bg-white rounded shadow-md py-10 px-16'>

        <h1 className='text-2xl font-medium mb-12 text-center'>
          Admin login
        </h1>

        {error && (
          <div className='bg-red-200 rounded py-3 px-5 mb-5'>
            {error}
          </div>
        )}

        <form onSubmit={handleFormSubmit}>

          <div>
            <label htmlFor='username'>Usuário</label>
            <FormInput placeholder='O padrão é admin' id="username" />
          </div>

          <div>
            <label htmlFor='password'>Senha</label>
            <FormInput type='password' placeholder='O padrão é secret' id="password" />
          </div>

          <div className='flex justify-center items-center mt-6'>
            <PrimaryButton>Entrar</PrimaryButton>
          </div>

        </form>
      </div>
    </div>
  );
}

export default LoginPage;
