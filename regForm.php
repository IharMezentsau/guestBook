<div class="modal fade" id="registration" tabindex="-1" role="dialog" aria-label="Сообщение" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button class="close" type="button" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Регистрация нового пользователя</h4>
            </div>
            <div class="modal-body">
                <form id="formReg" >
                    <div class="form-group">
                        <input type="text" id="eMailReg" name="newEMailReg" class="form-control" placeholder="Введите E-mail *" value="">
                    </div>
                    <div class="form-group" id="invalidEmail" style="color: red"></div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="newUserName" id="nameId" placeholder="Введите Имя" value="">
                    </div>
                    <div class="form-group">
                        <input type="password" id="passwordReg" class="form-control" placeholder="Введите пароль *" value="" name="passwordReg">
                    </div>
                    <div class="form-group">
                        <input type="password" id="confirmPasswordReg" class="form-control" placeholder="Подтвердите пароль *" value="" name="confirmPasswordReg">
                    </div>
                    <div class="form-group" id="invalidPass" style="color: red"></div>

                    <div class="modal-footer">
                        <button type="submit" id="regBtn" class="btn btn-primary">
                            <i class="fas fa-address-card"></i> Зарегистрироваться
                        </button>
                    </div>
                </form>
            </div>

            <div class="modal-body">
                <p style="color: red">* Поля обязательные для заполнения</p>
            </div>
        </div>
    </div>
</div>