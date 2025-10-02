import Checkbox from '@/Components/Checkbox';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import GuestLayout from '@/Layouts/GuestLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function Login({ status, canResetPassword }) {
    const { data, setData, post, processing, errors, reset } = useForm({
        email: '',
        password: '',
        remember: false,
    });

    const submit = (e) => {
        e.preventDefault();
        post(route('login'), {
            onFinish: () => reset('password'),
        });
    };

    return (
        <GuestLayout>
            <Head title="Log in" />

            <div className="container d-flex justify-content-center align-items-center min-vh-100">
                <div className="card shadow-lg p-4" style={{ maxWidth: "420px", width: "100%" }}>
                    <div className="text-center mb-4">
                        <h3 className="fw-bold">Bienvenue</h3>
                        <p className="text-muted mb-0">Connectez-vous pour continuer</p>
                    </div>

                    {status && (
                        <div className="alert alert-success text-sm text-center">
                            {status}
                        </div>
                    )}

                    <form onSubmit={submit}>
                        {/* Email */}
                        <div className="mb-3">
                            <InputLabel htmlFor="email" value="Email" />
                            <TextInput
                                id="email"
                                type="email"
                                name="email"
                                value={data.email}
                                className="form-control mt-1"
                                autoComplete="username"
                                isFocused={true}
                                onChange={(e) => setData('email', e.target.value)}
                            />
                            <InputError message={errors.email} className="text-danger small mt-1" />
                        </div>

                        {/* Password */}
                        <div className="mb-3">
                            <InputLabel htmlFor="password" value="Mot de passe" />
                            <TextInput
                                id="password"
                                type="password"
                                name="password"
                                value={data.password}
                                className="form-control mt-1"
                                autoComplete="current-password"
                                onChange={(e) => setData('password', e.target.value)}
                            />
                            <InputError message={errors.password} className="text-danger small mt-1" />
                        </div>

                        {/* Remember Me */}
                        <div className="mb-3 form-check">
                            <Checkbox
                                className="form-check-input"
                                id="remember"
                                name="remember"
                                checked={data.remember}
                                onChange={(e) => setData('remember', e.target.checked)}
                            />
                            <label className="form-check-label ms-2" htmlFor="remember">
                                Se souvenir de moi
                            </label>
                        </div>

                        {/* Actions */}
                        <div className="d-flex justify-content-between align-items-center">
                            {canResetPassword && (
                                <Link
                                    href={route('password.request')}
                                    className="text-decoration-none small text-primary"
                                >
                                    Mot de passe oublié ?
                                </Link>
                            )}

                            <PrimaryButton
                                className="btn btn-primary px-4"
                                disabled={processing}
                            >
                                Connexion
                            </PrimaryButton>
                        </div>
                    </form>

                    {/* Register */}
                    <div className="text-center mt-4">
                        <p className="small mb-0">
                            Pas encore de compte ?{" "}
                            <Link href={route('register')} className="text-decoration-none fw-bold text-primary">
                                Inscrivez-vous
                            </Link>
                        </p>
                    </div>
                </div>
            </div>
        </GuestLayout>
    );
}
