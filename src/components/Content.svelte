<script>
    import Cards from "./cards/cards.svelte";
    import { saveFormDataToServer, getToken } from "../functions/get-register";

    let csrf = "Esperando token...";

    async function getHash() {
        csrf = await getToken("api/?tt");
    }

    getHash();

    $: csrf = csrf;

    async function handleForm(e) {
        e.preventDefault();
        const data = await saveFormDataToServer(this, false);
        console.log(data);
    }
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
            <div class="container__inner">
                <h3>Formulario de prueba</h3>
                <form action="api/" method="post" on:submit={handleForm}>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        placeholder="Nombre de prueba"
                    />
                    <input
                        type="text"
                        name="lastname"
                        id="lastname"
                        placeholder="Apellidos"
                    />
                    <input
                        type="text"
                        name="year"
                        id="year"
                        placeholder="edad"
                    />
                    <input type="hidden" name="token" value="{csrf}" />

                    <hr />

                    <button type="submit" class="button"
                        >Ejecutar una prueba</button
                    >
                </form>

                <p>{csrf}</p>
            </div>
        </section>

        <section class="container__item">
            <article class="container__inner">
                <h3>Crear sesión de usuario</h3>

                <p>Formulario temporal para probar la creación de la sesión de usuario</p>

                <form action="api/" method="post" on:submit={handleForm}>
                    <input type="hidden" name="token" value="{csrf}" />

                    <input type="text" name="username" id="username" placeholder="Su usuario" />
                    <input type="password" name="password" id="password" placeholder="Su contraseña" />
                    <button type="submit" class="button">
                        Crear sesión de usuario
                    </button>

                    <hr>

                    <p><a href="#olvidar">¿Olvidó su contraseña?</a></p>
                </form>

                <p>{csrf}</p>
            </article>

            <article class="container__item">
                <div class="container__inner">
                    <h3>Actualizar usuario especifico</h3>
                    <p>La actualización se hace sin comproboción con fines de investigación</p>

                    <form action="api/" method="post" on:submit="{handleForm}">
                        <input type="hidden" name="token" value="{csrf}" />
                        <input type="hidden" name="username" id="username" value="dlunamontilla">
                        <input type="text" name="password" id="password" placeholder="Actualizar Contraseña" />

                        <input type="hidden" name="actions" id="validate" value="update" />

                        <button type="submit" class="button button--success">Actualizar contraseña</button>
                    </form>
                </div>
            </article>

            <article class="container__item">
                <div class="container__inner">
                    <a href="http://localhost:8080" target="_blank">Probar enlace</a>
                </div>
            </article>
        </section>

        <section class="container__item">
            <article class="container__inner">
                <h2>Nuestros vendedores</h2>
            </article>
        </section>
    </div>
</main>
