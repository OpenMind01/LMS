<?php

namespace Pi\Domain\Industries;

use Pi\Exceptions\Industries\IndustryCannotBeReadyException;
use Pi\Http\Requests\Industries\IndustryCloneRequest;
use Pi\Http\Requests\Industries\IndustryCreateRequest;
use Pi\Http\Requests\Industries\IndustryUpdateRequest;
use Pi\Usergroups\Usergroup;

class IndustriesService
{
    /**
     * @param int $id
     * @return Industry
     */
    public function get($id)
    {
        return Industry::findOrFail($id);
    }

    /**
     * @return \Illuminate\Database\Query\Builder
     */
    public function query()
    {
        return Industry::orderBy('ready', 'desc')->orderBy('title');
    }

    /**
     * @return \Illuminate\Database\Query\Builder
     */
    public function queryOpen()
    {
        return Industry::whereReady(true)->orderBy('title');
    }

    /**
     * @param IndustryCreateRequest $request
     * @return Industry
     */
    public function create(IndustryCreateRequest $request)
    {
        $this->checkRequest($request);

        $industry = new Industry();
        $industry->title = $request->getTitle();
        $industry->ready = $request->getReady();

        $industry->save();

        $industry->usergroups()->sync($request->getUsergroups());

        return $industry;
    }

    /**
     * @param Industry $industry
     * @param IndustryUpdateRequest $request
     * @throws IndustryCannotBeReadyException
     */
    public function update(Industry $industry, IndustryUpdateRequest $request)
    {
        $this->checkRequest($request);

        $industry->usergroups()->sync($request->getUsergroups());

        $industry->title = $request->getTitle();
        $industry->ready = $request->getReady();

        $industry->save();
    }

    /**
     * @param Industry $fromIndustry
     * @param IndustryCloneRequest $request
     * @return Industry
     */
    public function cloneFromOtherIndustry(Industry $fromIndustry, IndustryCloneRequest $request)
    {
        $industry = new Industry();
        $industry->title = $request->getTitle();

        $industry->save();

        $industry->usergroups()->sync($fromIndustry->usergroups);
        $industry->ready = $fromIndustry->ready;

        $industry->save();

        return $industry;
    }

    /**
     * @param IndustryCreateRequest $request
     * @throws IndustryCannotBeReadyException
     */
    private function checkRequest(IndustryCreateRequest $request)
    {
        if ($request->getReady())
        {
            // Check does this request have ready user groups
            $atLeastOneUsergroupIsReady = false;

            foreach (Usergroup::whereIn('id', $request->getUsergroups())->get() as $usergroup)
            {
                if ($usergroup->ready)
                {
                    $atLeastOneUsergroupIsReady = true;
                    break;
                }
            }

            if (!$atLeastOneUsergroupIsReady)
            {
                throw new IndustryCannotBeReadyException("At least one user group should be ready");
            }
        }
    }
}