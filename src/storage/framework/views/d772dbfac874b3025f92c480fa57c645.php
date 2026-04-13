<?php $__env->startSection('content'); ?>
<div class="profile-edit">
    <h1 class="profile-edit-title">プロフィール設定</h1>

    <form action="<?php echo e(route('profile.update')); ?>" method="POST" enctype="multipart/form-data" class="profile-form">
        <?php echo csrf_field(); ?>
        <?php echo method_field('POST'); ?>

        
        <div class="profile-image-section">
            <div class="profile-image-upload__preview-wrap">
                <?php if(auth()->user()->profile_image): ?>
                    <img id="profile-preview"
                         src="<?php echo e(Storage::url(auth()->user()->profile_image)); ?>"
                         alt="プロフィール画像"
                         class="profile-image-upload__preview">
                <?php else: ?>
                    <div id="profile-preview-placeholder" class="profile-image-upload__placeholder"></div>
                    <img id="profile-preview" src="" alt="" class="profile-image-upload__preview" style="display:none;">
                <?php endif; ?>
            </div>
            <label for="profile_image" class="btn btn--outline profile-image-upload__btn">
                画像を選択する
                <input type="file" id="profile_image" name="profile_image"
                       accept=".jpeg,.jpg,.png" class="profile-image-upload__input">
            </label>
            <?php $__errorArgs = ['profile_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span class="form-error"><?php echo e($message); ?></span>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="form-group">
            <label class="form-label" for="name">ユーザー名</label>
            <input
                type="text"
                id="name"
                name="name"
                value="<?php echo e(old('name', auth()->user()->name)); ?>"
                class="form-input <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> form-input--error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
            >
            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span class="form-error"><?php echo e($message); ?></span>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="form-group">
            <label class="form-label" for="postal_code">郵便番号</label>
            <input
                type="text"
                id="postal_code"
                name="postal_code"
                value="<?php echo e(old('postal_code', auth()->user()->postal_code)); ?>"
                placeholder="123-4567"
                class="form-input <?php $__errorArgs = ['postal_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> form-input--error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
            >
            <?php $__errorArgs = ['postal_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span class="form-error"><?php echo e($message); ?></span>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="form-group">
            <label class="form-label" for="address">住所</label>
            <input
                type="text"
                id="address"
                name="address"
                value="<?php echo e(old('address', auth()->user()->address)); ?>"
                class="form-input <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> form-input--error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
            >
            <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <span class="form-error"><?php echo e($message); ?></span>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="form-group">
            <label class="form-label" for="building">建物名</label>
            <input
                type="text"
                id="building"
                name="building"
                value="<?php echo e(old('building', auth()->user()->building)); ?>"
                class="form-input"
            >
        </div>

        <button type="submit" class="btn btn--primary btn--full">更新する</button>
    </form>
</div>

<script>
document.getElementById('profile_image').addEventListener('change', function (e) {
    const file = e.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = function (ev) {
        const preview     = document.getElementById('profile-preview');
        const placeholder = document.getElementById('profile-preview-placeholder');
        if (preview) {
            preview.src = ev.target.result;
            preview.style.display = 'block';
        }
        if (placeholder) {
            placeholder.style.display = 'none';
        }
    };
    reader.readAsDataURL(file);
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/mypage/profile.blade.php ENDPATH**/ ?>