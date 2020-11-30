{literal}
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <section id="comments" class="col-12">
        <div v-for="comment in comments">
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
                                    <i class="text-danger fa fa-trash"></i>
                                </a>
                            {/literal}
                        {/if}
                    {literal}
                </div>
            </div>
        </div>
    </section>
    <div id="modalDeleteComment" class="modal fade" aria-hidden="true">
	    <div class="modal-dialog modal-confirm">
            <div class="modal-content">
                <div class="modal-header flex-column">
                    <div class="icon-box">
                        <i class="fas fa-exclamation"></i>
                    </div>						
                    <h4 class="modal-title w-100">¿Estas seguro? </h4>	
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <p>¿Realmente queres eliminar este comentario? está acción no puede ser revertida</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button"  class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="btn-delete-comment" class="btn btn-danger">Eliminar</button>
                </div>
            </div>
        </div>
    </div>
{/literal}