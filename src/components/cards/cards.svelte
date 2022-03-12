<script>
    import Info from "../icons/Info.svelte";

    let products = [
        {
            id: 1,
            name: "David E Luna M",
            description: "Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorem, aliquam.",
            a: ""
        },
        {
            id: 2,
            name: "Gipsemar Gacía",
            description:
                "Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorem, aliquam.",
        },
        {
            id: 3,
            name: "Jesús García",
            description:
                "Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorem, aliquam.",
        },
        {
            id: 3,
            name: "Omar Pérez",
            description:
                "Lorem ipsum dolor sit amet consectetur adipisicing elit. Dolorem, aliquam.",
        },
    ];
</script>

<div class="card">
    {#each products as { id, name, description }, index}
        <div class="card__item">
            <header class="card__image">
                <img
                    src="images/photos/hangers-blur.jpg"
                    alt="Foto de {name}"
                />
            </header>
            
            <!-- <div class="card__container">
                <section class="card__description">
                    <h4 class="card__title">{name}</h4>
                    <p>{description}</p>
                </section>

                <section class="card__details">
                    <a href="#details" class="button button--primary"
                        >Ver detalles y solicitar</a
                    >
                </section>
            </div> -->

            <section class="card__container">
                <h2 class="card__title">
                    {name}
                </h2>

                <section class="card__description">{description}</section>

                <section class="card__details">
                    <button class="button button--primary">
                        <Info />
                        Realizar pedido
                    </button>
                </section>
            </section>
        </div>
    {/each}
</div>
