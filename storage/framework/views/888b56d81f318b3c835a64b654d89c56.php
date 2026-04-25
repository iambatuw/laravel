<?php $__env->startSection('title', 'Öğretmen Düzenle | Nöbet Kontrol'); ?>
<?php $__env->startSection('page-title'); ?>
    <span class="text-muted fw-light">Profil Yönetimi:</span> <?php echo e($teacher->name); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-lg overflow-hidden">
                <div class="card-header py-4 px-5 border-0 d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-3">
                        <div class="p-2 rounded-3 bg-warning bg-opacity-10 text-warning">
                            <i class="bi bi-pencil-square fs-4"></i>
                        </div>
                        <h5 class="mb-0 fw-bold">Eğitmen Bilgilerini Güncelle</h5>
                    </div>
                </div>
                <div class="card-body p-4 p-md-5">
                    <form action="<?php echo e(route('teachers.update', $teacher)); ?>" method="POST" enctype="multipart/form-data" id="teacherEditForm">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <div class="row g-4">
                            <!-- Sol Kolon: Temel Bilgiler -->
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="form-label mb-3 fw-bold small text-muted text-uppercase tracking-wider">Ad Soyad</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-dark border-0 text-primary px-3"><i class="bi bi-person-badge"></i></span>
                                        <input type="text" class="form-control bg-dark border-0 text-light py-3 <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="name" value="<?php echo e(old('name', $teacher->name)); ?>" required>
                                    </div>
                                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback d-block mt-2"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label mb-3 fw-bold small text-muted text-uppercase tracking-wider">E-posta Adresi</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-dark border-0 text-primary px-3"><i class="bi bi-envelope-at"></i></span>
                                        <input type="email" class="form-control bg-dark border-0 text-light py-3 <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="email" value="<?php echo e(old('email', $teacher->email)); ?>" required>
                                    </div>
                                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback d-block mt-2"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label mb-3 fw-bold small text-muted text-uppercase tracking-wider">Uzmanlık / Branş</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-dark border-0 text-primary px-3"><i class="bi bi-mortarboard"></i></span>
                                        <select class="form-select bg-dark border-0 text-light py-3 <?php $__errorArgs = ['branch'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="branch" required>
                                            <?php $__currentLoopData = ['Matematik', 'Türkçe', 'Fizik', 'Kimya', 'Biyoloji', 'Tarih', 'Coğrafya', 'İngilizce', 'Almanca', 'Müzik', 'Beden Eğitimi', 'Görsel Sanatlar', 'Bilişim Teknolojileri', 'Din Kültürü', 'Felsefe', 'Edebiyat']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($branch); ?>" <?php echo e(old('branch', $teacher->branch) === $branch ? 'selected' : ''); ?>><?php echo e($branch); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <?php $__errorArgs = ['branch'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback d-block mt-2"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <!-- Sağ Kolon: Detaylar -->
                            <div class="col-md-6">
                                <div class="mb-4">
                                    <label class="form-label mb-3 fw-bold small text-muted text-uppercase tracking-wider">İletişim Numarası</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-dark border-0 text-primary px-3"><i class="bi bi-phone"></i></span>
                                        <input type="text" class="form-control bg-dark border-0 text-light py-3 <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="phone" value="<?php echo e(old('phone', $teacher->phone)); ?>">
                                    </div>
                                    <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback d-block mt-2"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label mb-3 fw-bold small text-muted text-uppercase tracking-wider">Sistem Yetkisi</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-dark border-0 text-primary px-3"><i class="bi bi-shield-check"></i></span>
                                        <select class="form-select bg-dark border-0 text-light py-3 <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="role" required>
                                            <option value="teacher" <?php echo e(old('role', $teacher->role) === 'teacher' ? 'selected' : ''); ?>>Öğretmen</option>
                                            <option value="admin" <?php echo e(old('role', $teacher->role) === 'admin' ? 'selected' : ''); ?>>Sistem Yöneticisi</option>
                                        </select>
                                    </div>
                                    <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback d-block mt-2"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label mb-3 fw-bold small text-muted text-uppercase tracking-wider">Profil Görseli</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-dark border-0 text-primary px-3"><i class="bi bi-image"></i></span>
                                        <input type="file" class="form-control bg-dark border-0 text-light py-3 <?php $__errorArgs = ['avatar'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="avatar" accept="image/*">
                                    </div>
                                    <?php if($teacher->avatar): ?>
                                        <div class="mt-2 small text-info"><i class="bi bi-info-circle me-1"></i> Mevcut bir profil fotoğrafı tanımlı.</div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="col-12 my-3">
                                <div class="d-flex align-items-center gap-3">
                                    <hr class="flex-grow-1 opacity-10">
                                    <span class="text-muted small fw-bold text-uppercase">Güvenlik Ayarları</span>
                                    <hr class="flex-grow-1 opacity-10">
                                </div>
                            </div>

                            <!-- Şifre Kolonu -->
                            <div class="col-md-6">
                                <label class="form-label mb-3 fw-bold small text-muted text-uppercase tracking-wider">Yeni Şifre (İsteğe Bağlı)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-dark border-0 text-warning px-3"><i class="bi bi-key"></i></span>
                                    <input type="password" class="form-control bg-dark border-0 text-light py-3 <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="password" placeholder="Değiştirmek istemiyorsanız boş bırakın">
                                </div>
                                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback d-block mt-2"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label mb-3 fw-bold small text-muted text-uppercase tracking-wider">Şifre Onayı</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-dark border-0 text-warning px-3"><i class="bi bi-key-fill"></i></span>
                                    <input type="password" class="form-control bg-dark border-0 text-light py-3" name="password_confirmation" placeholder="Yeni şifreyi onaylayın">
                                </div>
                            </div>
                        </div>

                        <div class="d-flex align-items-center justify-content-between mt-5 pt-4 border-top border-light border-opacity-10">
                            <a href="<?php echo e(route('teachers.index')); ?>" class="btn btn-dark px-4 py-3 rounded-3 border-0" style="background: rgba(255,255,255,0.05);">
                                <i class="bi bi-arrow-left me-2"></i> İptal ve Geri Dön
                            </a>
                            <button type="submit" class="btn btn-warning px-5 py-3 rounded-3 shadow-lg fw-bold border-0 text-dark">
                                <i class="bi bi-save2-fill me-2"></i> Bilgileri Güncelle
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\batuh\OneDrive\Masaüstü\laravel\resources\views/teachers/edit.blade.php ENDPATH**/ ?>