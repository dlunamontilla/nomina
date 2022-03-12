<script>
    import { saveFormDataToServer } from "./functions/get-register";
    import Logo from "./components/icons/Logo.svelte";
    import Menu from "./components/Menu.svelte";
    import Cards from "./components/cards/cards.svelte";

    /** @type { Promise<any> } */
    let datos;

    async function enviarFormulario(e) {
        e.preventDefault();
        datos = await saveFormDataToServer(this, false);
    }

    let data = datos;
    $: data = datos;

    async function getData(path) {
        const response = await fetch(path);
        const data = await response.text();
        return data;
    }

    let path = "";
    let requestData = getData(`./api/?${path}`);
    $: requestData = getData(`./api/?${path}`);
</script>


<header class="header">
    <nav class="navigation">
        <Logo />
        <Menu />
    </nav>

    <div class="banner">
        <div class="banner__inner">
            Algún banner que pronto se colocará
        </div>
    </div>
</header>

<main id="wrapper">
    
    <div class="container">
        <section class="container__item">

            <div class="container__inner">
                <h2>Recientes</h2>
                <hr>
            
                <Cards />
            </div>

        </section>

        <section class="container__item">
            <article class="container__inner">
                <h2>Los más buscados</h2>
                <hr>
        
                <Cards />
            </article>
        </section>

        <section class="container__item">
            <article class="container__inner">
                <h2>Nuestros vendedores</h2>
            </article>
        </section>
    </div>

</main>

<footer class="footer">
    Todos los derechos reservados
    <div class="footer__inner" />
</footer>
