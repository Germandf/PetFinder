{literal}
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <section id="comments">
        <div class="col-12" v-for="comment in comments">
            <div class="media g-mb-30 media-comment">
                <div class="media-body shadow g-bg-secondary g-pa-30">
                    <div class="g-mb-15">
                        <h3 class="h5 mb-0">{{ comment.name }}</h3>
                    </div>
                    <p>{{ comment.message }}</p>
                    <p><b>Seguridad de haberlo visto {{comment.rate}}/5</b></p>
                        {/literal}
                            {if isset($smarty.session.PERMISSION_USER) && $smarty.session.PERMISSION_USER == 1}
                                {literal}
                                    <a href="#" :data-id="comment.id" v-on:click="remove">
                                        <i  class="text-danger fa fa-trash"></i>
                                    </a>
                                {/literal}
                            {/if}
                        {literal}
                </div>
            </div>
        </div>
    </section>
{/literal}