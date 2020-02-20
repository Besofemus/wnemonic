<?php

/*
 * SPDX-License-Identifier: AGPL-3.0-or-later

 * Copyright (C) 2020 Roman Erdyakov

 * This file is part of Wnemonic. It is a tag based file manager.

 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.

 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.

 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */


namespace Tests\Feature\Request;

use \App\Literal;
use \App\Utils\FileInfo;
use \Tests\Feature\Seeder;
use \Tests\Feature\FakeFile;


class DeleteFile extends \Tests\TestCase
{
    public function setUp() : void
    {
        parent::setUp();
        
        $this->fakeFile = new FakeFile;
        Seeder::seedFile($this->fakeFile);
    }
    
    /**
     * Checks if post delete request redirects to home
     * @test
     * @return void
     */
    public function redirectAfterDelete() : void
    {
        $response = $this->post("/delete",
                                array(Literal::nameField() => $this->fakeFile->name()));
        
        $response->assertRedirect("/");
    }

    /**
     * Checks if post request deletes file
     * @test
     * @return void
     */
    public function deleteFile() : void
    {
        $this->post("/delete",
                    array(Literal::nameField() => $this->fakeFile->name()));

        \Storage::assertMissing(FileInfo::hashPath($this->fakeFile->name()));
    }

    private FakeFile $fakeFile;
}
