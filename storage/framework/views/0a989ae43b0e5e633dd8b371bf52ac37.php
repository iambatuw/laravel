

<?php $__env->startSection('title', $teacher->name . ' - Öğretmen Detayı'); ?>
<?php $__env->startSection('page-title', 'Öğretmen Detayı'); ?>

<?php $__env->startSection('content'); ?>
    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card text-center">
                <div class="card-body py-4">
                    <div class="user-avatar mx-auto mb-3" style="width:80px;height:80px;font-size:28px;border-radius:16px;">
                        <?php echo e(strtoupper(substr($teacher->name, 0, 1))); ?>

                    </div>
                    <h4 class="fw-bold mb-1"><?php echo e($teacher->name); ?></h4>
                    <span class="badge bg-light text-dark mb-3" style="border-radius: 6px;"><?php echo e($teacher->branch); ?></span>

                    <div class="text-start mt-3 px-3">
                        <div class="d-flex justify-content-between py-2 border-bottom">
                            <span class="text-muted" style="font-size:13px;"><i class="bi bi-envelope me-2"></i>E-posta</span>
                            <span style="font-size:13px;" class="fw-semibold"><?php echo e($teacher->email); ?></span>
                        </div>
                        <div class="d-flex justify-content-between py-2 border-bottom">
                            <span class="text-muted" style="font-size:13px;"><i class="bi bi-phone me-2"></i>Telefon</span>
                            <span style="font-size:13px;" class="fw-semibold"><?php echo e($teacher->phone ?? '-'); ?></span>
                        </div>
                        <div class="d-flex justify-content-between py-2 border-bottom">
                            <span class="text-muted" style="font-size:13px;"><i class="bi bi-person-badge me-2"></i>Rol</span>
                            <span style="font-size:13px;" class="fw-semibold"><?php echo e($teacher->isAdmin() ? 'Yönetici' : 'Öğretmen'); ?></span>
                        </div>
                        <div class="d-flex justify-content-between py-2">
                            <span class="text-muted" style="font-size:13px;"><i class="bi bi-calendar-plus me-2"></i>Kayıt</span>
                            <span style="font-size:13px;" class="fw-semibold"><?php echo e($teacher->created_at->format('d.m.Y')); ?></span>
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4 justify-content-center">
                        <a href="<?php echo e(route('teachers.edit', $teacher)); ?>" class="btn btn-primary-gradient">
                            <i class="bi bi-pencil me-1"></i>Düzenle
                        </a>
                        <a href="<?php echo e(route('assignments.teacher_history', $teacher)); ?>" class="btn btn-outline-primary" style="border-radius: 8px;">
                            <i class="bi bi-clock-history me-1"></i>Nöbet Geçmişi
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-calendar-check me-2 text-primary"></i>Son Nöbet Atamaları</h5>
                </div>
                <div class="card-body p-0">
                    <?php if($recentDuties->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Tarih</th>
                                        <th>Gün</th>
                                        <th>Nöbet Yeri</th>
                                        <th>Zaman</th>
                                        <th>Durum</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $recentDuties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $duty): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="fw-semibold"><?php echo e($duty->dutySchedule->date->format('d.m.Y')); ?></td>
                                            <td><?php echo e($duty->dutySchedule->day_of_week); ?></td>
                                            <td><i class="bi bi-geo-alt text-primary me-1"></i><?php echo e($duty->location->name); ?></td>
                                            <td><span class="badge-status badge-<?php echo e($duty->period); ?>"><?php echo e($duty->period_label); ?></span></td>
                                            <td><span class="badge-status badge-<?php echo e($duty->status); ?>"><?php echo e($duty->status_label); ?></span></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center p-3">
                            <?php echo e($recentDuties->links()); ?>

                        </div>
                    <?php else: ?>
                        <div class="empty-state">
                            <i class="bi bi-calendar-x d-block"></i>
                            <h5>Henüz nöbet ataması yok</h5>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\batuh\OneDrive\Masaüstü\laravel\resources\views/teachers/show.blade.php ENDPATH**/ ?>