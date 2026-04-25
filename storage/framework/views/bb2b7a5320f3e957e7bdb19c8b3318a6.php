<?php $__env->startSection('title', 'Yeni Çizelge | Nöbet Kontrol'); ?>
<?php $__env->startSection('page-title', 'Yeni Nöbet Çizelgesi Hazırlama'); ?>

<?php $__env->startSection('content'); ?>
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card border-0 shadow-lg overflow-hidden">
                <div class="card-header py-4 px-5 border-0 d-flex align-items-center gap-3">
                    <div class="p-2 rounded-3 bg-primary bg-opacity-10 text-primary">
                        <i class="bi bi-calendar-plus fs-4"></i>
                    </div>
                    <h5 class="mb-0 fw-bold">Çizelge Temel Bilgileri</h5>
                </div>
                <div class="card-body p-4 p-md-5">
                    <form action="<?php echo e(route('schedules.store')); ?>" method="POST" id="scheduleForm">
                        <?php echo csrf_field(); ?>

                        <div class="row g-4">
                            <div class="col-md-12">
                                <label class="form-label mb-3 fw-bold small text-muted text-uppercase tracking-wider">Planlama Tarihi</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-dark border-0 text-primary px-4"><i class="bi bi-calendar-check"></i></span>
                                    <input type="date" class="form-control bg-dark border-0 text-light py-3 <?php $__errorArgs = ['date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="date" name="date" value="<?php echo e(old('date', date('Y-m-d'))); ?>" required>
                                </div>
                                <?php $__errorArgs = ['date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback d-block mt-2"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label mb-3 fw-bold small text-muted text-uppercase tracking-wider">Çizelge Başlığı</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-dark border-0 text-primary px-4"><i class="bi bi-journal-check"></i></span>
                                    <input type="text" class="form-control bg-dark border-0 text-light py-3 <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="title" name="title" value="<?php echo e(old('title')); ?>" placeholder="Örn: 1. Dönem Final Haftası Nöbetleri">
                                </div>
                                <div class="form-text text-muted small mt-2">Boş bırakılırsa tarih bilgisi otomatik başlık olarak kullanılır.</div>
                                <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback d-block mt-2"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-12">
                                <label class="form-label mb-3 fw-bold small text-muted text-uppercase tracking-wider">Özel Notlar (Opsiyonel)</label>
                                <textarea class="form-control bg-dark border-0 text-light <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="notes" name="notes" rows="4" placeholder="Nöbetçi öğretmenler için ek açıklamalar veya hatıtmalar..."><?php echo e(old('notes')); ?></textarea>
                                <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback d-block mt-2"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <div class="info-card mt-5 p-4 rounded-4" style="background: rgba(79, 70, 229, 0.05); border: 1px dashed rgba(79, 70, 229, 0.2);">
                            <div class="d-flex gap-3">
                                <i class="bi bi-info-circle-fill text-primary fs-4"></i>
                                <div>
                                    <h6 class="fw-bold mb-1 text-light">Sonraki Adım: Atamalar</h6>
                                    <p class="text-muted small mb-0">Çizelge taslağı oluşturulduktan sonra öğretmenleri nöbet yerlerine atayabileceksiniz.</p>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex align-items-center justify-content-between mt-5 pt-4 border-top border-light border-opacity-10">
                            <a href="<?php echo e(route('schedules.index')); ?>" class="btn btn-dark px-4 py-3 rounded-3 border-0" style="background: rgba(255,255,255,0.05);">
                                <i class="bi bi-arrow-left me-2"></i> İptal ve Geri Dön
                            </a>
                            <button type="submit" class="btn btn-primary px-5 py-3 rounded-3 shadow-lg fw-bold border-0">
                                <i class="bi bi-plus-circle-fill me-2"></i> Çizelge Oluştur
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\batuh\OneDrive\Masaüstü\laravel\resources\views/schedules/create.blade.php ENDPATH**/ ?>