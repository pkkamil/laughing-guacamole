<article class="search">
    <section class="search__bar">
        <div class="search__bar__content">
            <form autocomplete="off" method="GET" action="">
                <label class="search__bar__content__input" for="q">
                    <input type="text" placeholder="Szukaj" name="q" id="q" autocomplete="OFF" required>
                    <button><i class="fas fa-search"></i></button>
                </label>
            </form>
        </div>
    </section>
</article>
<script>
    document.querySelector('.navbar__content__icons__search').addEventListener('click', (e) => {
        document.querySelector('.search').style.display = 'block'
        document.querySelector('.search__bar__content__input input').focus()
    })

    document.querySelector('.navbar--mobile__links__single--search').addEventListener('click', (e) => {
        document.querySelector('.search').style.display = 'block'
        document.querySelector('.search__bar__content__input input').focus()
    })

    document.addEventListener('mouseup', (e) => {
        if (!document.querySelector('.search__bar').contains(e.target))
            document.querySelector('.search').style.display = 'none'
    })
</script>