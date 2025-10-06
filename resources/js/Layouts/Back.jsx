import Footer from "@/Components/Footer";
import Nav from "@/Components/Nav";



export default function Back ({children}) {


    return (
        <>
            <Nav/>
            <main>
                {children}
            </main>
            <Footer/>
        </>
    )
}