<script>
    import Cards from "./cards/cards.svelte";
</script>

<main id="wrapper">
    <div class="container">
        <section class="container__item">
            <div class="container__inner">
                <h2>Recientes</h2>
                <hr />

                <Cards />
            </div>
        </section>

        <section class="container__item">
            <article class="container__inner">
                <h2>Los más buscados</h2>
                <hr />

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
