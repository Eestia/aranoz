import Nav from "@/Components/Nav";



export default function Front ({children}) {


    return (
        <>
            <Nav/>
            <main>
                {children}
            </main>
        </>
    )
}