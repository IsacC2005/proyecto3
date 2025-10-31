<?php

namespace App\Http\Middleware;

use App\Constants\RoleConstants;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Repositories\LearningProjectRepository;

class EnsureProjectBelongsToTeacher
{
    public function __construct(protected LearningProjectRepository $projectRepository) {}
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $projectId = $request->input('projectId');
        $user = Auth::user();

        if ($projectId & !$user->hasRole(RoleConstants::ADMINISTRADOR)) {
            $belongs = $this->projectRepository->existProjectForTeacher($projectId, $user->userable_id);

            if (!$belongs) {
                activity('Acceso denegado')->causedBy($user)->log('Intento ver notas de proyecto no asignado.');

                abort(403, 'No eres el profesor de este proyecto.');
            }
        }

        return $next($request);
    }
}
