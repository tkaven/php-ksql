<?php
declare(strict_types=1);

/**
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

namespace Istyle\KsqlClient;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\ClientInterface;
use Istyle\KsqlClient\Exception\StreamQueryException;
use Istyle\KsqlClient\Query\AbstractStreamQuery;
use Istyle\KsqlClient\Query\QueryInterface;
use Istyle\KsqlClient\Mapper\AbstractMapper;

/**
 * Class StreamClient
 */
final class StreamClient extends RestClient
{
    /**
     * build GuzzleHttp Client
     *
     * @return ClientInterface
     */
    protected function buildClient(): ClientInterface
    {
        return new GuzzleClient([
            'headers' => [
                'User-Agent' => $this->userAgent(),
                'Accept'     => 'application/json',
            ],
            'stream'  => true,
        ]);
    }

    /**
     * @param QueryInterface $query
     * @param int            $timeout
     * @param bool           $debug
     *
     * @return AbstractMapper
     */
    public function requestQuery(
        QueryInterface $query,
        int $timeout = 500000,
        bool $debug = false
    ): AbstractMapper {
        if ($query instanceof AbstractStreamQuery) {
            return parent::requestQuery($query, $timeout, $debug);
        }
        throw new StreamQueryException(
            "You must extends " . AbstractStreamQuery::class
        );
    }
}
