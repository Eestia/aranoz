import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import GuestLayout from '@/Layouts/GuestLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function Register() {
    const { data, setData, post, processing, errors, reset } = useForm({
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
    });

    const submit = (e) => {
        e.preventDefault();

        post(route('register'), {
            onFinish: () => reset('password', 'password_confirmation'),
        });
    };

    return (
        <GuestLayout>
            <Head title="Register" />

            <div className="container d-flex justify-content-center align-items-center min-vh-100">
                <div className="card shadow-lg p-4" style={{ maxWidth: "480px", width: "100%" }}>
                    <div className="text-center mb-4">
                        <h3 className="fw-bold">Créer un compte</h3>
                        <p className="text-muted mb-0">
                            Rejoignez-nous et commencez votre aventure
                        </p>
                    </div>

                    <form onSubmit={submit}>
                        {/* Name */}
                        <div className="mb-3">
                            <InputLabel htmlFor="name" value="Nom" />
                            <TextInput
                                id="name"
                                name="name"
                                value={data.name}
                                className="form-control mt-1"
                                autoComplete="name"
                                isFocused={true}
                                onChange={(e) => setData('name', e.target.value)}
                                required
                            />
                            <InputError message={errors.name} className="text-danger small mt-1" />
                        </div>

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
                                onChange={(e) => setData('email', e.target.value)}
                                required
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
                                autoComplete="new-password"
                                onChange={(e) => setData('password', e.target.value)}
                                required
                            />
                            <InputError message={errors.password} className="text-danger small mt-1" />
                        </div>

                        {/* Confirm Password */}
                        <div className="mb-3">
                            <InputLabel htmlFor="password_confirmation" value="Confirmer le mot de passe" />
                            <TextInput
                                id="password_confirmation"
                                type="password"
                                name="password_confirmation"
                                value={data.password_confirmation}
                                className="form-control mt-1"
                                autoComplete="new-password"
                                onChange={(e) => setData('password_confirmation', e.target.value)}
                                required
                            />
                            <InputError message={errors.password_confirmation} className="text-danger small mt-1" />
                        </div>

                        {/* Actions */}
                        <div className="d-flex justify-content-between align-items-center mt-4">
                            <Link
                                href={route('login')}
                                className="text-decoration-none small text-primary"
                            >
                                Déjà inscrit ? Connectez-vous
                            </Link>

                            <PrimaryButton
                                className="btn btn-success px-4"
                                disabled={processing}
                            >
                                S’inscrire
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </GuestLayout>
    );
}
