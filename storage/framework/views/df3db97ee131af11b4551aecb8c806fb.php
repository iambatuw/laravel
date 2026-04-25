

<?php $__env->startSection('title', 'Yeni Takas Talebi'); ?>
<?php $__env->startSection('page-title', 'Yeni Takas Talebi Oluştur'); ?>

<?php $__env->startSection('content'); ?>
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-arrow-left-right me-2 text-primary"></i>Takas Talebi Bilgileri</h5>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('swap-requests.store')); ?>" method="POST" id="swapForm">
                        <?php echo csrf_field(); ?>

                        <div class="mb-3">
                            <label class="form-label" for="duty_assignment_id">Takas Etmek İstediğiniz Nöbet <span class="text-danger">*</span></label>
                            <select class="form-select <?php $__errorArgs = ['duty_assignment_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="duty_assignment_id" name="duty_assignment_id" required>
                                <option value="">Nöbet Seçin</option>
                                <?php $__currentLoopData = $myAssignments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assignment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($assignment->id); ?>" <?php echo e(old('duty_assignment_id') == $assignment->id ? 'selected' : ''); ?>>
                                        <?php echo e($assignment->dutySchedule->date->format('d.m.Y')); ?> - <?php echo e($assignment->location->name); ?> (<?php echo e($assignment->period_label); ?>)
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['duty_assignment_id'];
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

                        <div class="mb-3">
                            <label class="form-label" for="target_id">Takas Etmek İstediğiniz Öğretmen <span class="text-danger">*</span></label>
                            <select class="form-select <?php $__errorArgs = ['target_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="target_id" name="target_id" required>
                                <option value="">Öğretmen Seçin</option>
                                <?php $__currentLoopData = $teachers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $teacher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($teacher->id); ?>" <?php echo e(old('target_id') == $teacher->id ? 'selected' : ''); ?>>
                                        <?php echo e($teacher->name); ?> (<?php echo e($teacher->branch); ?>)
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['target_id'];
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

                        <div class="mb-3">
                            <label class="form-label" for="reason">Sebep</label>
                            <textarea class="form-control <?php $__errorArgs = ['reason'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="reason" name="reason" rows="3" placeholder="Takas sebebinizi belirtin..."><?php echo e(old('reason')); ?></textarea>
                            <?php $__errorArgs = ['reason'];
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

                        <div class="alert alert-warning" style="border-radius: 10px; border: none;">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            Takas talebi yönetici onayına gönderilecektir.
                        </div>

                        <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                            <a href="<?php echo e(route('swap-requests.index')); ?>" class="btn btn-outline-secondary" style="border-radius: 8px;">
                                <i class="bi bi-arrow-left me-1"></i>Geri
                            </a>
                            <button type="submit" class="btn btn-primary-gradient" id="btnSendSwap">
                                <i class="bi bi-send me-1"></i>Talebi Gönder
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\batuh\OneDrive\Masaüstü\laravel\resources\views/swap_requests/create.blade.php ENDPATH**/ ?>