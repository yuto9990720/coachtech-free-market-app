<?php $__env->startSection('content'); ?>
<div class="sell-page">
    <h1 class="sell-page-title">商品の出品</h1>

    <form action="<?php echo e(route('exhibition.store')); ?>" method="POST" enctype="multipart/form-data" class="sell-form">
        <?php echo csrf_field(); ?>

        
        <div class="sell-form__section">
            <h2 class="sell-form__section-title">商品画像</h2>
            <div class="form-group">
                <label for="image" class="image-upload__label">
                    <div class="image-upload__area" id="image-preview-area">
                        <img id="image-preview" src="" alt="" style="display:none;" class="image-upload__preview">
                        <span id="image-placeholder">
                            <span class="image-upload__placeholder-btn">画像を選択する</span>
                        </span>
                    </div>
                    <input type="file" id="image" name="image" accept=".jpeg,.jpg,.png" class="image-upload__input">
                </label>
                <?php $__errorArgs = ['image'];
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
        </div>

        
        <div class="sell-form__section">
            <h2 class="sell-form__section-title">商品の詳細</h2>

            <div class="form-group" style="margin-bottom: 24px;">
                <span class="category-label">カテゴリー</span>
                <div class="category-tags">
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <label class="category-tag">
                            <input
                                type="checkbox"
                                name="category_ids[]"
                                value="<?php echo e($category->id); ?>"
                                <?php echo e(in_array($category->id, old('category_ids', [])) ? 'checked' : ''); ?>

                                class="category-tag__input"
                            >
                            <span class="category-tag__label"><?php echo e($category->name); ?></span>
                        </label>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php $__errorArgs = ['category_ids'];
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
                <label class="form-label" for="condition_id">商品の状態</label>
                <select id="condition_id" name="condition_id"
                        class="form-select <?php $__errorArgs = ['condition_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> form-input--error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <option value="">選択してください</option>
                    <?php $__currentLoopData = $conditions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $condition): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($condition->id); ?>"
                            <?php echo e(old('condition_id') == $condition->id ? 'selected' : ''); ?>>
                            <?php echo e($condition->name); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['condition_id'];
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
        </div>

        
        <div class="sell-form__section">
            <h2 class="sell-form__section-title">商品名と説明</h2>

            <div class="form-group" style="margin-bottom: 24px;">
                <label class="form-label" for="name">商品名</label>
                <input type="text" id="name" name="name" value="<?php echo e(old('name')); ?>"
                       class="form-input <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> form-input--error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
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

            <div class="form-group" style="margin-bottom: 24px;">
                <label class="form-label" for="brand">ブランド名</label>
                <input type="text" id="brand" name="brand" value="<?php echo e(old('brand')); ?>"
                       class="form-input">
            </div>

            <div class="form-group">
                <label class="form-label" for="description">商品の説明</label>
                <textarea id="description" name="description" rows="6"
                          class="form-input form-textarea <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> form-input--error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                          ><?php echo e(old('description')); ?></textarea>
                <?php $__errorArgs = ['description'];
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
        </div>

        
        <div class="sell-form__section">
            <h2 class="sell-form__section-title">販売価格</h2>
            <div class="form-group">
                <label class="form-label" for="price">販売価格</label>
                <div class="price-input-wrap">
                    <span class="price-input-wrap__symbol">¥</span>
                    <input type="number" id="price" name="price" value="<?php echo e(old('price')); ?>" min="0"
                           class="form-input price-input-wrap__input <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> form-input--error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                </div>
                <?php $__errorArgs = ['price'];
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
        </div>

        <div style="padding: 40px 0;">
            <button type="submit" class="btn btn--primary btn--full">出品する</button>
        </div>
    </form>
</div>

<script>
document.getElementById('image').addEventListener('change', function (e) {
    const file = e.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = function (ev) {
        const preview     = document.getElementById('image-preview');
        const placeholder = document.getElementById('image-placeholder');
        preview.src       = ev.target.result;
        preview.style.display = 'block';
        placeholder.style.display = 'none';
    };
    reader.readAsDataURL(file);
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/resources/views/items/sell.blade.php ENDPATH**/ ?>