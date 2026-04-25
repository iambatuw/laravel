

<?php $__env->startSection('title', 'Nöbet Geçmişi - ' . $teacher->name); ?>
<?php $__env->startSection('page-title', $teacher->name . ' - Nöbet Geçmişi'); ?>

<?php $__env->startSection('content'); ?>
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div class="d-flex align-items-center gap-3">
            <div class="user-avatar" style="width:48px;height:48px;font-size:18px;border-radius:12px;">
                <?php echo e(strtoupper(substr($teacher->name, 0, 1))); ?>

            </div>
            <div>
                <h5 class="mb-0 fw-bold"><?php echo e($teacher->name); ?></h5>
                <span class="text-muted" style="font-size: 13px;"><?php echo e($teacher->branch); ?> - Nöbet Geçmişi</span>
            </div>
        </div>
        <a href="<?php echo e(route('teachers.show', $teacher)); ?>" class="btn btn-outline-primary" style="border-radius: 8px;">
            <i class="bi bi-arrow-left me-1"></i>Öğretmen Profiline Dön
        </a>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <?php if($assignments->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tarih</th>
                                <th>Gün</th>
                                <th>Nöbet Yeri</th>
                                <th>Kat</th>
                                <th>Zaman</th>
                                <th>Saat</th>
                                <th>Durum</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $assignments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assignment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="fw-semibold"><?php echo e($assignment->dutySchedule->date->format('d.m.Y')); ?></td>
                                    <td><?php echo e($assignment->dutySchedule->day_of_week); ?></td>
                                    <td><i class="bi bi-geo-alt text-primary me-1"></i><?php echo e($assignment->location->name); ?></td>
                                    <td style="color: #666;"><?php echo e($assignment->location->floor ?? '-'); ?></td>
                                    <td><span class="badge-status badge-<?php echo e($assignment->period); ?>"><?php echo e($assignment->period_label); ?></span></td>
                                    <td style="font-size: 12px; color: #999;">
                                        <?php if($assignment->start_time && $assignment->end_time): ?>
                                            <?php echo e(\Carbon\Carbon::parse($assignment->start_time)->format('H:i')); ?> - <?php echo e(\Carbon\Carbon::parse($assignment->end_time)->format('H:i')); ?>

                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                    <td><span class="badge-status badge-<?php echo e($assignment->status); ?>"><?php echo e($assignment->status_label); ?></span></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-center p-3">
                    <?php echo e($assignments->links()); ?>

                </div>
            <?php else: ?>
                <div class="empty-state">
                    <i class="bi bi-calendar-x d-block"></i>
                    <h5>Nöbet geçmişi bulunmuyor</h5>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\batuh\OneDrive\Masaüstü\laravel\resources\views/assignments/teacher_history.blade.php ENDPATH**/ ?>