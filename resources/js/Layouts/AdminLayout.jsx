export default function AdminLayout({ children }) {
  return (
    <div className="min-h-screen flex flex-col bg-gray-100">
      {/* Header */}
      <header className="bg-gray-800 text-white p-4">
        <h1 className="text-lg font-bold">Admin Panel</h1>
      </header>

      {/* Contenu principal */}
      <main className="flex-1 p-6">
        {children}
      </main>
    </div>
  );
}
