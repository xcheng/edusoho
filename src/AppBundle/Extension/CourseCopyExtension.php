<?php

namespace AppBundle\Extension;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class CourseCopyExtension extends Extension implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Container $biz)
    {
        $self = $this;
        $biz['course_copy'] = function ($biz) use ($self) {
            $processes = $self->processNodes();
            $courseNodes = $self->generateCourseNodes();

            return new $processes['course']['class']($biz, $courseNodes);
        };

        $biz['classroom_course_copy'] = function ($biz) use ($self) {
            $processes = $self->processNodes();
            $classroomNodes = $self->generateClassroomNodes();

            return new $processes['classroom_course']['class']($biz, $classroomNodes);
        };
    }

    public function processNodes()
    {
        $processNodes['course'] = array(
            'class' => 'Biz\Course\Copy\Impl\CourseCopy',
        );
        $processNodes['classroom_course'] = array(
            'class' => 'Biz\Course\Copy\Impl\ClassroomCourseCopy',
        );

        return $processNodes;
    }

    public function generateCourseNodes()
    {
        return array(
            'course-member' => array(
                'class' => 'Biz\Course\Copy\Impl\CourseMemberCopy',
                'priority' => 100,
            ),
            'task' => array(
                'class' => 'Biz\Course\Copy\Impl\TaskCopy',
                'priority' => 90,
            ),
        );
    }

    public function generateClassroomNodes()
    {
        return array(
            'material' => array(
                'class' => 'Biz\Course\Copy\Impl\CourseMaterialCopy',
                'priority' => 100,
            ),
            'course-member' => array(
                'class' => 'Biz\Course\Copy\Impl\CourseMemberCopy',
                'priority' => 90,
            ),
            'classroom-teacher' => array(
                'class' => 'Biz\Course\Copy\Impl\ClassroomTeacherCopy',
                'priority' => 80,
            ),
            'courseset-question' => array(
                'class' => 'Biz\Course\Copy\Impl\CourseSetQuestionCopy',
                'priority' => 70,
            ),
            'courseset-testpaper' => array(
                'class' => 'Biz\Course\Copy\Impl\CourseSetTestpaperCopy',
                'priority' => 60,
            ),
            'task' => array(
                'class' => 'Biz\Course\Copy\Impl\TaskCopy',
                'priority' => 50,
            ),
        );
    }
}
