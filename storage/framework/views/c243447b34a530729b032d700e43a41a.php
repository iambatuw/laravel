

<?php $__env->startSection('title', 'Çizelge Düzenle'); ?>
<?php $__env->startSection('page-title', 'Çizelge Düzenle'); ?>

<?php $__env->startSection('content'); ?>
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-pencil-square me-2 text-primary"></i><?php echo e($schedule->date->format('d.m.Y')); ?> Çizelgesini Düzenle</h5>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('schedules.update', $schedule)); ?>" method="POST" id="scheduleEditForm">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Tarih</label>
                                <input type="text" class="form-control" value="<?php echo e($schedule->date->format('d.m.Y')); ?> - <?php echo e($schedule->day_of_week); ?>" disabled>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label" for="status">Durum <span class="text-danger">*</span></label>
                                <select class="form-select <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="status" name="status" required>
                                    <option value="draft" <?php echo e(old('status', $schedule->status) === 'draft' ? 'selected' : ''); ?>>Taslak</option>
                                    <option value="published" <?php echo e(old('status', $schedule->status) === 'published' ? 'selected' : ''); ?>>Yayında</option>
                                    <option value="completed" <?php echo e(old('status', $schedule->status) === 'completed' ? 'selected' : ''); ?>>Tamamlandı</option>
                                </select>
                                <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-12">
                                <label class="form-label" for="title">Başlık</label>
                                <input type="text" class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="title" name="title" value="<?php echo e(old('title', $schedule->title)); ?>">
                                <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-12">
                                <label class="form-label" for="notes">Notlar</label>
                                <textarea class="form-control <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="notes" name="notes" rows="3"><?php echo e(old('notes', $schedule->notes)); ?></textarea>
                                <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                            <a href="<?php echo e(route('schedules.show', $schedule)); ?>" class="btn btn-outline-secondary" style="border-radius: 8px;">
                                <i class="bi bi-arrow-left me-1"></i>Geri
                            </a>
                            <button type="submit" class="btn btn-primary-gradient" id="btnUpdateSchedule">
                                <i class="bi bi-check-lg me-1"></i>Güncelle
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\batuh\OneDrive\Masaüstü\laravel\resources\views/schedules/edit.blade.php ENDPATH**/ ?>