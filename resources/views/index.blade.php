<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css' rel='stylesheet'>

    <link href="{{asset("css/custom.css")}}" rel="stylesheet">
    <title>Календар</title>
</head>

<body>

<div class="container">

    <h2 class="mb-4">Порядок денний</h2>

    <span id="msg"></span>

    <div id='calendar'></div>

</div>

<!-- Modal Visualizar -->
<div class="modal fade" id="visualizarModal" tabindex="-1" aria-labelledby="visualizarModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h1 class="modal-title fs-5" id="visualizarModalLabel">Опишіть подію</h1>

                <h1 class="modal-title fs-5" id="editarModalLabel" style="display: none;">Редагування події</h1>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <span id="msgViewEvento"></span>

                <div id="visualizarEvento">

                    <dl class="row">

                        <dt class="col-sm-3">ID: </dt>
                        <dd class="col-sm-9" id="visualizar_id"></dd>

                        <dt class="col-sm-3">Назва: </dt>
                        <dd class="col-sm-9" id="visualizar_title"></dd>

                        <dt class="col-sm-3">Опис: </dt>
                        <dd class="col-sm-9" id="visualizar_obs"></dd>

                        <dt class="col-sm-3">Початок: </dt>
                        <dd class="col-sm-9" id="visualizar_start"></dd>

                        <dt class="col-sm-3">Кінець: </dt>
                        <dd class="col-sm-9" id="visualizar_end"></dd>

                    </dl>

                    <button type="button" class="btn btn-warning" id="btnViewEditEvento">Редагувати </button>

                    <button type="button" class="btn btn-danger" id="btnApagarEvento">Видалити</button>

                </div>

                <div id="editarEvento" style="display: none;">

                    <span id="msgEditEvento"></span>

                    <form method="POST" id="formEditEvento">

                        <input type="hidden" name="edit_id" id="edit_id">

                        <div class="row mb-3">
                            <label for="edit_title" class="col-sm-2 col-form-label">Назва</label>
                            <div class="col-sm-10">
                                <input type="text" name="edit_title" class="form-control" id="edit_title" placeholder="Título do evento">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="edit_obs" class="col-sm-2 col-form-label">Опис</label>
                            <div class="col-sm-10">
                                <input type="text" name="edit_obs" class="form-control" id="edit_obs" placeholder="Опис події">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="edit_start" class="col-sm-2 col-form-label">Початок</label>
                            <div class="col-sm-10">
                                <input type="datetime-local" name="edit_start" class="form-control" id="edit_start">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="edit_end" class="col-sm-2 col-form-label">Кінець</label>
                            <div class="col-sm-10">
                                <input type="datetime-local" name="edit_end" class="form-control" id="edit_end">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="edit_color" class="col-sm-2 col-form-label">Колір</label>
                            <div class="col-sm-10">
                                <select name="edit_color" class="form-control" id="edit_color">
                                    <option value="">Виберіть</option>
                                    <option style="color:#FFD700;" value="#FFD700">Жовтий</option>
                                    <option style="color:#0071c5;" value="#0071c5">Бірюзово-блакитний</option>
                                    <option style="color:#FF4500;" value="#FF4500">Помаранчевий</option>
                                    <option style="color:#8B4513;" value="#8B4513">Коричневий</option>
                                    <option style="color:#1C1C1C;" value="#1C1C1C">Чорний</option>
                                    <option style="color:#436EEE;" value="#436EEE">Королівський блакитний</option>
                                    <option style="color:#A020F0;" value="#A020F0">Фіолетовий.</option>
                                    <option style="color:#40E0D0;" value="#40E0D0">Бірюза</option>
                                    <option style="color:#228B22;" value="#228B22">Зелений</option>
                                    <option style="color:#8B0000;" value="#8B0000">Червоний</option>
                                </select>
                            </div>
                        </div>

                        <button type="button" name="btnViewEvento" class="btn btn-primary" id="btnViewEvento">Календар</button>

                        <button type="submit" name="btnEditEvento" class="btn btn-warning" id="btnEditEvento">Зберегти</button>

                    </form>

                </div>

            </div>
        </div>
    </div>
</div>

<!-- Modal Cadastrar -->
<div class="modal fade" id="cadastrarModal" tabindex="-1" aria-labelledby="cadastrarModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="cadastrarModalLabel">Додати подію</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <span id="msgCadEvento"></span>

                <form method="POST" id="formCadEvento">

                    <div class="row mb-3">
                        <label for="cad_title" class="col-sm-2 col-form-label">Назва</label>
                        <div class="col-sm-10">
                            <input type="text" name="cad_title" class="form-control" id="cad_title" placeholder="Назва події">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="cad_obs" class="col-sm-2 col-form-label">Опис</label>
                        <div class="col-sm-10">
                            <input type="text" name="cad_obs" class="form-control" id="cad_obs" placeholder="Опис події">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="cad_start" class="col-sm-2 col-form-label">Початок</label>
                        <div class="col-sm-10">
                            <input type="datetime-local" name="cad_start" class="form-control" id="cad_start">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="cad_end" class="col-sm-2 col-form-label">Кінець</label>
                        <div class="col-sm-10">
                            <input type="datetime-local" name="cad_end" class="form-control" id="cad_end">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="cad_color" class="col-sm-2 col-form-label">Колір</label>
                        <div class="col-sm-10">
                            <select name="cad_color" class="form-control" id="cad_color">
                                <option value="">Вибрати</option>
                                <option style="color:#FFD700;" value="#FFD700">Жовтий</option>
                                <option style="color:#0071c5;" value="#0071c5">Бірюзово-блакитний</option>
                                <option style="color:#FF4500;" value="#FF4500">Помаранчевий</option>
                                <option style="color:#8B4513;" value="#8B4513">Коричневий</option>
                                <option style="color:#1C1C1C;" value="#1C1C1C">Чорний</option>
                                <option style="color:#436EEE;" value="#436EEE">Королівський блакитний</option>
                                <option style="color:#A020F0;" value="#A020F0">Фіолетовий.</option>
                                <option style="color:#40E0D0;" value="#40E0D0">Бірюза</option>
                                <option style="color:#228B22;" value="#228B22">Зелений</option>
                                <option style="color:#8B0000;" value="#8B0000">Червоний</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" name="btnCadEvento" class="btn btn-success" id="btnCadEvento">Зберегти</button>

                </form>

            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
<script src={{asset('js/index.global.min.js')}}></script>
<script src={{asset("js/bootstrap5/index.global.min.js")}}></script>
<script src={{asset('js/core/locales-all.global.min.js')}}></script>
<script src={{asset('js/custom.js')}}></script>

</body>

</html>
